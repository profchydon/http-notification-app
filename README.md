## HTTP NOTIFICATION SYSTEM

A set of servers will keep track of `topics -> subscribers` where a topic is a string and a subscriber is an HTTP endpoint. When a message is published on a topic, it
will be forwarded to the subscriber endpoints.

## Tools Needed
- Docker

## Setup

- Clone repo
- Change to the application's directory `$ cd http-notification-app`
- Start the docker containers `$ docker-compose up -d --build`
- Visit publisher server URL like [http://localhost:8000](http://localhost:8000).
- Visit subscriber server URL like [http://localhost:8080](http://localhost:8080).


## How to test

- Complete all steps in the [SETUP](https://github.com/profchydon/http-notification-app#setup) section.
- ***CREATE A SUBSCRIPTION:***  Make a HTTP POST request to `http:localhost:8080/api/subscribe/country` as below:

    ```
        POST /api/subscribe/country
        // body
        {
         url: "http://localhost:8080/list-of-countries"
        }
    ```
     
- ***PUBLISH MESSAGE TO TOPIC:***  Make a HTTP POST request to `http:localhost:8080/api/publish/country` as below:

    ```
        POST /api/publish/country
        // body
        [
            {
                "name":"Nigeria",
                "continent": "Africa"
            },
            {
                "name":"Spain",
                "continent": "Europe"
            }
        ]
    ```
    
- ***VERIFY MESSAGE:***  Visit [http://localhost:8080/list-of-countries](http://localhost:8080/list-of-countries)