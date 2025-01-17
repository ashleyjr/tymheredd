#include <stdio.h>
#include <time.h>
#include <sys/time.h>
#include "sdkconfig.h"
#include "soc/soc_caps.h"
#include "freertos/FreeRTOS.h"
#include "freertos/task.h"
#include "esp_sleep.h"
#include "esp_log.h"
#include "driver/rtc_io.h"
#include <string.h>
#include "freertos/FreeRTOS.h"
#include "freertos/task.h"
#include "esp_system.h"
#include "esp_wifi.h"
#include "esp_event.h"
#include "esp_log.h"
#include "nvs_flash.h"
#include "protocol_examples_common.h"
#include "lwip/err.h"
#include "lwip/sockets.h"
#include "lwip/sys.h"
#include "lwip/netdb.h"
#include "lwip/dns.h"
#include "sdkconfig.h"
#include "../../../tymheredd_secret/secrets.h"

#define WEB_PORT "80"
#define WEB_PATH "/tymheredd/web/submit.php"

static const char *TAG = "tymheredd";

static const struct addrinfo hints = {
   .ai_family = AF_INET,
   .ai_socktype = SOCK_STREAM,
};

static void submit_then_sleep(void *pvParameters){ 
   struct addrinfo *res;
   struct in_addr *addr;
   int s, r;
   int err;
   int total_r;
   char recv_buf[256];
   char request[256];
  
   // Read sensors
   // TODO


   // Build the submission
   sprintf(request,
      "GET " 
      "/tymheredd/web/submit.php?"
      "password="PASSWORD"&"
      "temp=%d&"
      "time=%d"
      " HTTP/1.0\r\n"
      "Host: "WEB_SERVER":"WEB_PORT"\r\n"
      "User-Agent: esp-idf/1.0 esp32\r\n"
      "\r\n",
      0,
      0
   );
   ESP_LOGI(TAG, "Request (%d chars): \n\r%s", strlen(request), request);

   // Get IP address of WEB_SERVER from DNS 
   err = getaddrinfo(WEB_SERVER, WEB_PORT, &hints, &res);
   if(err != 0 || res == NULL) {
      ESP_LOGE(TAG, "DNS lookup failed err=%d res=%p", err, res);
      vTaskDelay(1000 / portTICK_PERIOD_MS);
      return;
   } 

   // Print resolved IP 
   addr = &((struct sockaddr_in *)res->ai_addr)->sin_addr;
   ESP_LOGI(TAG, "DNS lookup succeeded. IP=%s", inet_ntoa(*addr));

   // Get Socket and connect
   s = socket(res->ai_family, res->ai_socktype, 0);
   if(s < 0) {
      ESP_LOGE(TAG, "... Failed to allocate socket.");
      freeaddrinfo(res);
      vTaskDelay(1000 / portTICK_PERIOD_MS);
      return;
   }
   ESP_LOGI(TAG, "... allocated socket");
   if(connect(s, res->ai_addr, res->ai_addrlen) != 0) {
      ESP_LOGE(TAG, "... socket connect failed errno=%d", errno);
      close(s);
      freeaddrinfo(res);
      vTaskDelay(4000 / portTICK_PERIOD_MS);
      return;
   } 
   ESP_LOGI(TAG, "... connected");
   freeaddrinfo(res);
   
   // Send request (including data)
   if (write(s, request, strlen(request)) < 0) {
      ESP_LOGE(TAG, "... socket send failed");
      close(s);
      vTaskDelay(4000 / portTICK_PERIOD_MS);
      return;
   }
   ESP_LOGI(TAG, "... socket send success");

   // Receive socket
   struct timeval receiving_timeout;
   receiving_timeout.tv_sec = 5;
   receiving_timeout.tv_usec = 0;
   if (setsockopt(s, SOL_SOCKET, SO_RCVTIMEO, &receiving_timeout, sizeof(receiving_timeout)) < 0) {
      ESP_LOGE(TAG, "... failed to set socket receiving timeout");
      close(s);
      vTaskDelay(4000 / portTICK_PERIOD_MS);
      return;
   }
   ESP_LOGI(TAG, "... set socket receiving timeout success");
   
   // Read reponse and close off 
   total_r = 0;
   do {
      bzero(recv_buf, sizeof(recv_buf));
      r = read(s, recv_buf, sizeof(recv_buf)-1);
      for(int i = 0; i < r; i++) {
         putchar(recv_buf[i]);
      }
      total_r += r;
   } while(r > 0); 
   ESP_LOGI(TAG, "... done reading from socket.");
   ESP_LOGI(TAG, "Total chars=%d, last read return=%d, errno=%d.", total_r, r, errno);
   close(s);
   
   // Go to deep sleep ready to do it all over again 
   const int wakeup_time_sec = 60;
   printf("Enabling timer wakeup, %ds\n", wakeup_time_sec);
   ESP_ERROR_CHECK(esp_sleep_enable_timer_wakeup(wakeup_time_sec * 1000000));
   esp_deep_sleep_start();
}


void app_main(void){
    ESP_ERROR_CHECK(nvs_flash_init());
    ESP_ERROR_CHECK(esp_netif_init());
    ESP_ERROR_CHECK(esp_event_loop_create_default());
    ESP_ERROR_CHECK(example_connect());
    xTaskCreate(&submit_then_sleep, "submit_then_sleep", 4096, NULL, 5, NULL);
}
