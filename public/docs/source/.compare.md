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

#Messages and responses
Class MessageController
stores input message, watson response.
<!-- START_d81278cd36a9922790e42cb9cdc8ff62 -->
## api/messages/all

Returns a json array with all messages and the corresponding watsonResponse and mood change.

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
        "mood": 1
    },
    {
        "id": 2,
        "message": "-x",
        "response": "Hello. My name is Phil, What is your name?",
        "mood": 1
    },
    {
        "id": 3,
        "message": "fuck",
        "response": "I think you should see over your life choices.",
        "mood": -3
    }
]
```

### HTTP Request
`GET api/messages/all`

`HEAD api/messages/all`


<!-- END_d81278cd36a9922790e42cb9cdc8ff62 -->

<!-- START_cbf8fc5358a9792ab03acd386ea01cde -->
## api/messages/{id}

Returns the message, the watsonResponse, the moodchange factor and the general mood for the input message id.

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
## api/responses/{id}

Return just the watsonResponse for the input watsonResponse id.

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
## api/message/

Posts a message and returns the posted message, the watson response and the mood change factor;

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
## api/messages/{id}

Deletes a message and corresponding response and mood change from the chat.

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

