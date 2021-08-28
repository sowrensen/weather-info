## Weather Info REST API

This is a headless Laravel app that provides a REST API to get current weather info of the requested location. This
application was built solely for educational purpose.

### Installation

Follow standard Laravel application installation procedure.

### Configuration

This app gets the weather information from [WeatherStack](https://weatherstack.com/), hence requires an API key. Set the key
in your .env file as `WEATHER_STACK_KEY=`.

### Quick start

To get the weather info, you can hit `/api/weather?location=` route. This route supports both GET and POST methods.
However, even though the GET route doesn't require any authorization, the POST route is protected. You've to register
using `/api/register` and obtain an access token using `/api/login`. Use the token to make POST requests.

### Constraints

- The **GET** request is rate **limited by 5 requests per hour**, while the POST request doesn't have such limit.
- If you send three identical request consecutively, on the fourth identical attempt, the app will send a **429 Too Many
  Requests** error. This applies to both GET and POST `/api/weather` route.

### Endpoints provided by the application

#### 1. `/register` (POST)

Request:

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "HelloWorld#123"
}
```

Response:

```json
{
  "success": true,
  "message": "Registered successfully.",
  "data": {
    "user": {
      "name": "John Doe",
      "email": "john@example.com"
    },
    "token": "4|9DjcACwXBmN3FiB1GYzQEoKcxw9MTfngfpLRhV7G"
  }
}
```

#### 2. `/login` (POST)

Request:

```json
{
  "email": "john@example.com",
  "password": "HelloWorld#123"
}
```

Response:

```json
{
  "success": true,
  "message:": "Successfully logged in.",
  "data": {
    "token": "4|9DjcACwXBmN3FiB1GYzQEoKcxw9MTfngfpLRhV7G"
  }
}  
```

#### 3. `/logout` (Private/POST)

Response:

```json
{
  "success": true,
  "message": "Successfully logged out.",
  "data": null
}
```

#### 4. `/weather` (GET/POST)

When making POST request, set `Authorization: Beare <token>` header.

Query Params:

- `location`, e.g. `/api/weather?location=Chittagong` (required)

Response:

```json
{
  "status": true,
  "message": "Success",
  "data": {
    "location": {
      "name": "Chittagong",
      "country": "Bangladesh",
      "region": "",
      "lat": "22.364",
      "lon": "91.803",
      "timezone_id": "Asia/Dhaka",
      "localtime": "2021-08-28 15:40",
      "localtime_epoch": 1630165200,
      "utc_offset": "6.0"
    },
    "current_weather": {
      "observation_time": "09:40 AM",
      "temperature": 32,
      "weather_code": 116,
      "weather_icons": [
        "https://assets.weatherstack.com/images/wsymbols01_png_64/wsymbol_0002_sunny_intervals.png"
      ],
      "weather_descriptions": [
        "Partly cloudy"
      ],
      "wind_speed": 6,
      "wind_degree": 240,
      "wind_dir": "WSW",
      "pressure": 1001,
      "precip": 0,
      "humidity": 71,
      "cloudcover": 75,
      "feelslike": 41,
      "uv_index": 8,
      "visibility": 5,
      "is_day": "yes"
    }
  }
}
```
