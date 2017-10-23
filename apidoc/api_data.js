define({ "api": [
  {
    "type": "get",
    "url": "/app/",
    "title": "Request App Data",
    "name": "GetAppData",
    "group": "App",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "app_name",
            "description": "<p>Application Name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "api_version",
            "description": "<p>Api Version.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "api_doc",
            "description": "<p>Api Document Link.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/api/App.php",
    "groupTitle": "App"
  },
  {
    "type": "post",
    "url": "/user",
    "title": "Request User Infor",
    "name": "GetUserInfo",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>User's token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>Status response.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "data",
            "description": "<p>Data of user.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data.info",
            "description": "<p>Users info.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.user_id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.username",
            "description": "<p>User name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.email",
            "description": "<p>User email.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.fullname",
            "description": "<p>User full name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.created",
            "description": "<p>User date created.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.updated",
            "description": "<p>User date updated.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message of response.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/user/list/(:token)",
    "title": "Request User List",
    "name": "GetUserList",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>User's token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>Status response.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "data",
            "description": "<p>Data of user.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data.info",
            "description": "<p>Users info.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.user_id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.username",
            "description": "<p>User name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.email",
            "description": "<p>User email.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.fullname",
            "description": "<p>User full name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.created",
            "description": "<p>User date created.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.updated",
            "description": "<p>User date updated.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message of response.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/delete",
    "title": "Request User Delete",
    "name": "PostUserDelete",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>User's token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>Status response.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message of response.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/login",
    "title": "Request User Login",
    "name": "PostUserLogin",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User's email</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>User's password</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>Status response.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "data",
            "description": "<p>Data of user.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data.info",
            "description": "<p>Users info.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.user_id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.username",
            "description": "<p>User name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.email",
            "description": "<p>User email.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.fullname",
            "description": "<p>User full name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.created",
            "description": "<p>User date created.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.info.updated",
            "description": "<p>User date updated.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data.authorizationInfo",
            "description": "<p>Authorization info.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.authorizationInfo.authorize_key",
            "description": "<p>Authorization authorize key.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.authorizationInfo.refresh_key",
            "description": "<p>Authorization refresh key.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.authorizationInfo.key_expire",
            "description": "<p>Authorization token expire.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.authorizationInfo.status",
            "description": "<p>Authorization status.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message of response.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  }
] });
