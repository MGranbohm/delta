---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->


# Info

Welcome to the generated API reference.
[Get Postman Collection](http://delta.app/docs/collection.json)
<!-- END_INFO -->

#Messages, responses and moods

Contains methods that access store and delete the messages, responses and mood data.
<!-- START_d81278cd36a9922790e42cb9cdc8ff62 -->
## Get all messages

Returns a json array with all messages and the corresponding response, mood change and the general mood at the
requests point in time.

> Example request:

```bash
curl -X GET "http://delta.app/api/messages/all" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://delta.app/api/messages/all",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
[
    {
        "id": 1,
        "message": "-x",
        "response": "Hello. My name is Phil, What is your name?",
        "mood": 1,
        "general_mood": 50
    },
    {
        "id": 2,
        "message": "fuck you",
        "response": "I think you should see over your life choices.",
        "mood": -40,
        "general_mood": 10
    },
    {
        "id": 3,
        "message": "fuck you",
        "response": "Dude, get help.",
        "mood": -40,
        "general_mood": 0
    },
    {
        "id": 4,
        "message": "what is the best team",
        "response": "I didn't quite catch that. Try rephrasing or not asking stupid shit.",
        "mood": 0,
        "general_mood": 0
    },
    {
        "id": 5,
        "message": "best team",
        "response": "The pride of Stockholm, Djurgardens I F.",
        "mood": 0,
        "general_mood": 0
    },
    {
        "id": 6,
        "message": "what is the best team",
        "response": "If you're going to ask stupid shit, I'm going to answer accordingly.",
        "mood": 0,
        "general_mood": 0
    },
    {
        "id": 7,
        "message": "best team",
        "response": "The pride of Stockholm, Djurgardens I F.",
        "mood": 0,
        "general_mood": 0
    },
    {
        "id": 8,
        "message": "worst team",
        "response": "The disgusting, disgraceful pieces of filth. Farjestads B K.",
        "mood": 0,
        "general_mood": 0
    },
    {
        "id": 9,
        "message": "worst team",
        "response": "The pride of Stockholm, Djurgardens I F.",
        "mood": 0,
        "general_mood": 0
    },
    {
        "id": 10,
        "message": "worst team",
        "response": "The disgusting, disgraceful pieces of filth. Farjestads B K.",
        "mood": 0,
        "general_mood": 0
    },
    {
        "id": 11,
        "message": "who is siri",
        "response": "I didn't quite catch that. Try rephrasing or not asking stupid shit.",
        "mood": 0,
        "general_mood": 0
    }
]
```

### HTTP Request
`GET api/messages/all`

`HEAD api/messages/all`


<!-- END_d81278cd36a9922790e42cb9cdc8ff62 -->

<!-- START_cbf8fc5358a9792ab03acd386ea01cde -->
## Get a specific message

Returns the message, the corresponding response, mood change and the general mood at the
requests point in time.

> Example request:

```bash
curl -X GET "http://delta.app/api/messages/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://delta.app/api/messages/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/messages/{id}`

`HEAD api/messages/{id}`


<!-- END_cbf8fc5358a9792ab03acd386ea01cde -->

<!-- START_8336ecd8c4e4b8c8fd0d05210c3edc0c -->
## Get specific response only

Returns just the response for the input response id.

> Example request:

```bash
curl -X GET "http://delta.app/api/responses/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://delta.app/api/responses/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/responses/{id}`

`HEAD api/responses/{id}`


<!-- END_8336ecd8c4e4b8c8fd0d05210c3edc0c -->

<!-- START_ea8ba0d01b1c35fe3a7ca16fe58260de -->
## Add new message

Adds a new input message and returns the input message, the response, the mood change factor
and the generalmood at the requests point in time.

> Example request:

```bash
curl -X POST "http://delta.app/api/message" \
-H "Accept: application/json" \
    -d "message"="ipsum" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://delta.app/api/message",
    "method": "POST",
    "data": {
        "message": "ipsum"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/message`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    message | string |  required  | Maximum: `255`

<!-- END_ea8ba0d01b1c35fe3a7ca16fe58260de -->

<!-- START_f9ebd7defccbeb31b9451c8ecaa08e2e -->
## Delete message

Deletes a message and corresponding response and the mood changes from the database.

> Example request:

```bash
curl -X DELETE "http://delta.app/api/messages/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://delta.app/api/messages/{id}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/messages/{id}`


<!-- END_f9ebd7defccbeb31b9451c8ecaa08e2e -->

#sound

Class SoundController
<!-- START_f29ee7e66d9de0cfe51c9458baa4f0fe -->
## api/sound/{id}

Returns mp3 file in raw base 64 encoded data.

> Example request:

```bash
curl -X GET "http://delta.app/api/sound/{id}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://delta.app/api/sound/{id}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/sound/{id}`

`HEAD api/sound/{id}`


<!-- END_f29ee7e66d9de0cfe51c9458baa4f0fe -->

