## About Cylinder Manager

Manages Cylinder from depots to transporters to dealers and vice versa

## API

### Authentication and registration

`POST /api/oauth/register`

Before an organisation can use the app, the organisation admin creates an account.

Parameters
---

| Parameter |Required? | Description |
| ---------------|----------------|----------|
| firstName |required| |
| lastName |required| |
| username | optional | |
| phone |optional| |
| email | optional |Required if phone is empty |
| password |required| |
| confirmationPassword |required| |

Sample Request Data

```json
{
    "username": "",
    "email": "sawan.bernice@example.com",
    "phone": "283-858-1830",
    "firstName": "Jazlyn",
    "lastName": "Hand",
    "password": "password",
    "passwordConfirmation": "password"
}
```

Sample Response
---

```json
{
    "data": {
        "user": {
            "id": 2,
            "firstName": "Jazlyn",
            "lastName": "Hand",
            "email": "sawan.bernice@example.com",
            "phone": "283-858-1830",
            "createdAt": "2021-11-26T06:56:53.000000Z",
            "profileDescription": null,
            "emailVerified": false,
            "emailVerifiedAt": null,
            "phoneVerified": false,
            "phoneVerifiedAt": null,
            "profilePictureLink": null,
            "roles": [],
            "permissions": []
        },
        "token": {
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiN2MwZWU1NjE0ZmFjMjhlZTJjNmE2ZmI1NTM1MWI4ODQzNWI2ZjlmNTVjM2E5NTQ0MmE5ZjhjMzE0NzEyOGJmY2UwMDU5ZDJkNjg5ZDM2ZDEiLCJpYXQiOjE2Mzc5MDk4MTMuNDE3MjAxLCJuYmYiOjE2Mzc5MDk4MTMuNDE3MjA1LCJleHAiOjE2Njk0NDU4MTMuMzk4Njk0LCJzdWIiOiIyIiwic2NvcGVzIjpbIioiXX0.uAKUZQ-zCrRg5JZ-6nYxrpWl73WaiqqoC-EVsAmaQfnlZ5o28OTmgDAuIICxu0QzrBIVNTFUVjGrNRS-XoZn5BNoOidIMYCoLDVkfB40z0iGnU7uVKs-6e30hlRrCtpc9M0FmagdewYWIEqvwLbbdIGkxa69udme-S8KpQ-pC_f0ejWmhLaIB9-OFB4PoS1BwIV2JFsf10dD_uvFWvc7PKKaW1NLc14jOa6DSl24BPVZN8XyLEEUi2tAde-bJ4RW2k_8FIqVEyHozSVF52S38q-4NqZRgu94wvRDB6u4uhRipP67UrXBnw-JkdcIZlx0EFPg8nx8gcwSKkrsAXOECW0yTCGBKAahCyJ2xzWaIXowGNcCyZpM7OHPO_oDiHZz-DPj0sxMwnkelA69B-RA-bC-NdjLQcCuf5gKgACTm0q4EkWJ8YC0DER0NojaeHJIHnY_LPFQK74XvBoNnDI47VDC3yxnezrrRCOY-GGcjoFEG1sRs93WVl4HjFQosQweC2TAVrKfQHfoVBgHtkxfMqNMyc1i4tveP84VbN1GbyMCc_TXAOUilfff6_yfOcDUsRrZ-D9z8tf-b3nMGEx1rnEBSDpKQJkSauOdUqnzZ1-CZrJ6axcoxMcYJbuq6FD2u2wuImT1iBDnCPsUFG3c5HVlbppl-T1jhaospxpbkUY",
            "expires_in": "2022-11-26T06:56:53.000000Z"
        }
    },
    "header": {
        "message": "You have been successfully registered"
    }
}
```

`POST /api/depot-users`<br>
`POST /api/transporter-users`<br>
`POST /api/dealers-users`

After the admin creates an account, they have to select whether to set themselves as a
depot-users/transporter-user/dealer-user <br>
This step gives the user administrative rights to 'create depot users' or 'create transporter users' or 'create dealer
user' depending on the api call;<br>
This user will then be able to create other users within that particular domain

Parameters

`POST /api/depot-users`

| Api | Parameter |Required? | Description |
| ---------------|----------------|----------|---------|
|  |required| |

Sample Response
---

```json
{
    "data": {
        "id": 22,
        "username": "lhauck",
        "firstName": "Mandy",
        "lastName": "Hirthe",
        "email": "jamison64@example.com",
        "phone": "(724) 306-4332",
        "createdAt": "2021-11-28T17:11:04.000000Z",
        "depotUserId": 1,
        "profileDescription": null,
        "emailVerified": true,
        "emailVerifiedAt": "2021-11-28T17:11:04.000000Z",
        "phoneVerified": false,
        "phoneVerifiedAt": null,
        "profilePictureLink": null,
        "roles": [
            "Depot Admin"
        ],
        "permissions": [
            "create depot user"
        ]
    },
    "headers": {
        "message": "Successfully registered user as a depot user"
    }
}


```

### Brands

`POST /api/brands`

Creates a new brand

Parameters
---

|Parameter|required|Description|
|---------|-------|-------|
|brandName|required||

`GET /api/brands`

`GET /api/brands/{brandId}`

`PATCH /api/brands/{brandId}`

Updates brand details

Parameters
---

|Parameter|required|Description|
|---------|-------|-------|
|brandName|required||

`DELETE /api/brands/{brandId}`

Deletes brand

### Depots

`POST api/depots`

Creates depot

Headers
---

- Authorization

Permission to perform action
---

'create depot'

Sample request
---

```json
{
    "depotName": "Lake Carlotta",
    "depotCode": 851088,
    "depotEPRALicenceNo": 170025,
    "depotLocation": "Breanneton",
    "brandIds": [
        87
    ]
}
```

Sample response
---

```json
{
    "data": {
        "id": 206,
        "depotCode": 851088,
        "depotName": "Lake Carlotta",
        "depotEPRALicenceNo": null,
        "depotLocation": "Breanneton",
        "brands": [
            {
                "id": 87,
                "brandName": "Olson-Hoppe"
            }
        ]
    },
    "headers": {
        "message": "Depot created successfully"
    }
}
```

### Canisters

`POST api/depots/:depotId/canisters`

|Parameter|Required| Description|
|-------|--------|---------|
|canisterCode | required ||
|canisterManuf | required ||
|canisterManufDate | required ||
|brandId | required ||
|canisterRFID | required ||
|canisterRecertification | required ||

Sample Request Object
---

```json
{
    "canisterCode": 687981,
    "canisterManuf": "Schimmel, Blanda and Schaden",
    "canisterManufDate": "2020-09-06",
    "brandId": 191,
    "canisterRFID": 5355341,
    "canisterRecertificationDate": "1986-08-07"
}
```

Sample Response
---

```json
{
    "data": {
        "id": 143,
        "canisterCode": 3319956,
        "canisterRecertificationDate": "2009-01-20",
        "canisterManuf": "Dickens, Walter and Gulgowski",
        "canisterManufDate": "1978-06-28",
        "canisterRFID": 8478401,
        "brandId": 193,
        "brandName": "Upton-Okuneva"
    },
    "headers": {
        "message": "Successfully created canister"
    }
}
```

`GET api/depots/:depotId/canisters`

`GET api/depots/:depotId/canisters/:canisterId`

`PATCH api/depots/:depotId/canisters/:canisterId`

`DELETE api/depots/:depotId/canisters/:canisterId`
