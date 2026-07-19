# Local registration

Add `127.0.0.1 naxbooks.test demo.naxbooks.test` to local hosts, configure the placeholder MySQL credentials in `.env`, then visit `http://naxbooks.test:8000/register-business`. A provisioning account needs `CREATE DATABASE`; the runtime tenant account should not.
