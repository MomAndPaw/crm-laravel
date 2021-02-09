import requests
import json



def fetch_atoken():
    REFRESH_TOKEN="1000.c72c0dd5e0fecff0a6758a3570cae68d.a9f477ee88d79cb48579b1050f5200b2"
    CLIENT_ID="1000.J7N8MS1TRBDT3LI8FB6C9RJ4TR4G1T"
    CLIENT_SECRET="cd6ce68ae9a0dfe4394497233d7da126e3ca26b526"
    URL='https://accounts.zoho.in/oauth/v2/token'
    
    refresh_payload = {'refresh_token':REFRESH_TOKEN,'client_id':CLIENT_ID,'client_secret':CLIENT_SECRET,'grant_type':'refresh_token'}
    r=requests.post(URL,data=refresh_payload)
    r=json.loads(r.text)
    return r['access_token']


def insert_leads(token,l1):
    url = 'https://www.zohoapis.in/crm/v2/Leads'

    headers = {
        'Authorization': 'Zoho-oauthtoken '+token
    }

    request_body = dict()
    record_list = list()
    record_list.append(l1)
    request_body['data'] = record_list

    trigger = [
        'approval',
        'workflow',
        'blueprint'
    ]
    request_body['trigger'] = trigger
    response = requests.post(url=url, headers=headers, data=json.dumps(request_body).encode('utf-8'))
    return response.json()

data={"city":"Mumbai","cityIndex":4,"dogActivity":"Medium","dogAgeMonths":0,"dogAgeYears":1,
      "dogBodyScore":"1","dogBreedCategoriesIndex":4,"dogBreedCategoryUnknown":False,"dogGender":"Girl",
      "dogName":"Xxxx","dogNeutered":"No","dogWeight":15,
      "user":{"email":"","mobile":"8860620641","userName":"a b"}}    
ACCESS_TOKEN=fetch_atoken()
l1 = {
        'Company': 'Zylker',
        'Email': 'p.daly@zylker.com',
        'Last_Name': 'Daly',
        'First_Name': 'Paul',
        'Lead_Status': 'Contacted',
    }
name=data['user']['userName'].split();
l2 = {
        'Phone': data['user']['mobile'],
        'Email': data['user']['email'],
        'Last_Name': name[1],
        'First_Name': name[0],
        'City':data['city'],
        'Lead_Status': 'Contacted',
    }

print(l2)
r=insert_leads(ACCESS_TOKEN,l2)

print(r['data'][0]['status'])
