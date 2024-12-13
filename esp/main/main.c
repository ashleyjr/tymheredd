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

void app_main(void)
{
   /* Enable wakeup from deep sleep by rtc timer */ 
   const int wakeup_time_sec = 4;
   printf("Enabling timer wakeup, %ds\n", wakeup_time_sec);
   ESP_ERROR_CHECK(esp_sleep_enable_timer_wakeup(wakeup_time_sec * 1000000));
   esp_deep_sleep_start();

}
