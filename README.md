## HTTP NOTIFICATION SYSTEM

A set of servers will keep track of `topics -> subscribers` where a topic is a string and a subscriber is an HTTP endpoint. When a message is published on a topic, it
will be forwarded to the subscriber endpoints.

## Tools Needed
- Docker

## Setup

- Clone repo
- Change to the application's directory `$ cd http-notification-app`
- Start the docker containers `$ docker-compose up -d --build`
- Visit publisher serve URL like [http://localhost:8000](http://localhost:8000).
- Visit subscriber serve URL like [http://localhost:8080](http://localhost:8080).


