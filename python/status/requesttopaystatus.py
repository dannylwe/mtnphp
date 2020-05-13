import requests
import logging
import json
import uuid

logging.basicConfig(level=logging.DEBUG)

# refId = str(uuid.uuid4())
refId = "2213a644-efb9-465c-b131-2ecf5a45a250"
token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSMjU2In0.eyJjbGllbnRJZCI6IjFkYzQwNjliLTQ2OWMtNDM4MC1iOWNjLTIzOWIyZGNiMTQ2MSIsImV4cGlyZXMiOiIyMDIwLTA1LTEzVDA5OjEzOjEyLjU2NyIsInNlc3Npb25JZCI6ImIzMjg5NTExLTljMTAtNGU0NS05N2EzLTI4OTVkMjA0YzNmZSJ9.SEuDtQUwm5XkqzQqkHozfMWcKE0BxFh9IefddMIZy3EdlET7NwWUpjUm81u-xyXwX6jn4v499unzViAoHSftJFQTSdCql-aLh7wlzBNG0_lAjymMoR6dzvGIFKbTnBQmtEGzYPETQfKswred8XgEQ944do_E_3i_mx1j3hD9llJC0JthTCX1dQybg8oVdPT3y6O-28KA74OG-C4G8hbgBTAv_XNsh6Gu2DJrmsGeqj8rryqCSym6kwOMye3429SfdV4KxuqSqrHguuOWLX4pLWMhVWv6I_il0RtO_S0ujBMiv1oIfmuFvPI4dc-m5EIS0cWeoZSueX3Pz-hf3c5ABw"

payload = {
  "amount": "5.0",
  "currency": "EUR",
  "externalId": "2345678",
  "payer": {
    "partyIdType": "MSISDN",
    "partyId": "098765678356"
  },
  "payerMessage": "Pay your Yaka subscription",
  "payeeNote": "note to payer"
}
url = "https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay/"+refId
headers = {'content-type': 'application/json',
           'X-Reference-Id':refId,
           'X-Target-Environment':'sandbox',
           'Ocp-Apim-Subscription-Key':'6941dd1e3ff8404e844cb77afbbed8db',
           'Authorization': 'Bearer ' + token
           }

response = requests.get(url, headers=headers)
# data = (response.json())
print(response)
print(refId)
