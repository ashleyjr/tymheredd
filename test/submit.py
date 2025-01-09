import urllib.request
import urllib.parse
import time
import argparse

class Tester:

    def __init__(self, password_file, url_file):
        # Password
        with open(password_file) as f:
            self.password = f.read().rstrip()
        # URL
        with open(url_file) as f:
            self.url = f.read().rstrip()

    def test(self):

        # Clear data
        params = urllib.parse.urlencode({
            'password': self.password,
        })
        url = f"{self.url}/clear.php?%s" % params
        print(url)
        with urllib.request.urlopen(url) as f:
            print(f.read().decode('utf-8'))

        # Submit fake data
        for i in range(100):
            params = urllib.parse.urlencode({
                'password': self.password,
                'temp': i,
                'time': str(int(time.time()- (3600 * 4 * i))),
            })
            url = f"{self.url}/submit.php?%s" % params
            print(url)
            with urllib.request.urlopen(url) as f:
                print(f.read().decode('utf-8'))

            time.sleep(0.04)

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument('--password')
    parser.add_argument('--url')
    args = parser.parse_args()

    t = Tester(args.password, args.url)
    t.test()
