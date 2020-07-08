# Spotify Artist Albums Endpoint demo

This demo app was made with [Symfony](https://symfony.com/) framework

---

## Setup
1. clone the repo and enter into project folder
2. cp `.env` to `.env.local` file and fill the `SPOTIFY_CLIENT_ID` and `SPOTIFY_CLIENT_SECRET` fields
3. run `composer install`

## Usage
Into the project folder, start a server by running the following command:
```bash
symfony serve
```

>Note: you can use any port number

Now you can send a GET request with the name of the artist you want to get their albums from:

```bash
curl -X GET \
  'http://localhost/api/v1/albums?q=audioslave' \
  -H 'Accept: application/json'
```

Also you can use the cURL output with jq to get a pretty print of results

```bash
curl -X GET \
  'http://localhost/api/v1/albums?q=audioslave' \
  -H 'Accept: application/json' | jq
```

```json
[
  {
    "name": "Revelations",
    "released": "2006-09-05",
    "tracks": 13,
    "cover": {
      "height": 636,
      "url": "https://i.scdn.co/image/709b4d9163f432823ee9c8afe7e8795d9e08b4f5",
      "width": 640
    }
  },
  {
    "name": "Revelations",
    "released": "2006-09-01",
    "tracks": 13,
    "cover": {
      "height": 636,
      "url": "https://i.scdn.co/image/709b4d9163f432823ee9c8afe7e8795d9e08b4f5",
      "width": 640
    }
  },

  ...

  {
    "name": "Doesn't Remind Me",
    "released": "2005-01-01",
    "tracks": 2,
    "cover": {
      "height": 586,
      "url": "https://i.scdn.co/image/363cbe3b0d982d7d813ae8197d1964afc9f847ee",
      "width": 640
    }
  }
]
```