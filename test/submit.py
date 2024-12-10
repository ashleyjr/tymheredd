import urllib.request
import urllib.parse
import time

# Clear data
params = urllib.parse.urlencode({
    'password': "test",
})
url = "http://localhost:8000/clear.php?%s" % params
print(url)
with urllib.request.urlopen(url) as f:
    print(f.read().decode('utf-8'))

# Submit fake data
for i in range(100):
    params = urllib.parse.urlencode({
        'password': "test",
        'temp': i,
        'time': str(int(time.time()- (3600 * 4 * i))),
    })
    url = "http://localhost:8000/submit.php?%s" % params
    print(url)
    with urllib.request.urlopen(url) as f:
        print(f.read().decode('utf-8'))
