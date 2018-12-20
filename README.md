# Linee guida Test Zanichelli

# Installazione LAMP
```sh
git clone https://github.com/riccardodotti-web/zanichelli.git
in /opt/lampp/htdocs
```
### Add VirtualHost to LAMP
 - Open httpd-vhosts.conf using terminal
sudo nano /opt/lampp/etc/extra/httpd-vhosts.conf 
 - Add this row to file bottom
```sh
<VirtualHost *:80>
       DocumentRoot "/opt/lampp/htdocs/zanichelli/src"
       ServerName zanichelli.local
</VirtualHost>
```
### Map Local Host
 - Open hosts using terminal
sudo nano /etc/hosts
 - Add this row to file bottom
```sh
127.0.0.1       zanichelli.local
```
### Database
 - Open phpmyadmin
 - Crate zanichelli database MySql
 - Crate table clients or import zanichelli.sql file
```sh
CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;
```
# Descrizione del servizio offerto dalla API
Le Api esposte permettono le operazioni CRUD su clienti in un Database MySQL

### Url della API
http://zanichelli.local/api/test_api.php

### Elenco parametri e body playload
Parametri:
 - GET (all) action=fetch_all
 - GET (single) action=fetch_single&id=$id
 - POST (create) action=insert
 - POST (update) action=update
 - DELETE action=delete&id=$id

### Body payload accettati in input:
 - GET (single)
     - ID: id (int)
 - POST (create)
     - Nome: first_name (Text)
     - Cognome: last_name (Text)
 - POST (update)
     - ID: id (int)
     - Nome: first_name (Text)
     - Cognome: last_name (Text)
### Struttura della risposta della API
##### Codice Successo
 - 200 Ok: La risposta standard per rappresentare una operazione di tipo GET, PUT or POST (per azioni e non creazione risorsa) avvenuta con successo.
 - 201 Created: Questo codice andrebbe utilizzato lato server per comunicare che la nuova istanza è stata creata con successo. Ad esempio nella creazione di una nuova risorsa usando il metodo POST.
 - 204 No Content: significa che la richiesta è stata correttamente processata, ma non ha ritornato nessun contenuto. DELETE è un ottimo esempio di utilizzo di questo codice.
##### Codice Insuccesso
 - 400 Bad Request: indica che la richiesta non è stata processata perché il server non riconosce la richiesta come una tra quelle attese: ad esempio url errata o nome parametro errato.
 - 401 Unauthorized: indica che il client non ha i privilegi per accedere a tale risorsa (la API richiesta richiede l’autenticazione o un token di autenticazione).
 - 403 Forbidden: indica che la richiesta effettuata è valida e il client è correttamente autenticato, ma non ha i privilegi per poter utilizzare questa API.
 - 404 Not Found: indica che la risorsa richiesta non esiste o è momentaneamente non recuperabile.
 - 410 Gone: indica che la risorsa richiesta non è disponibile e intenzionalemente spostata.