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
    "type": "get",
    "url": "/user/:id",
    "title": "Request User List",
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
          }
        ]
      }
    },
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
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  }
] });
