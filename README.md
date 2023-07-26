# MoonLabs backend feladat

### Feladatleírás

A feladatod egy egyszerű csomagfeladó rendszer backendjének vázlatos implementációja és hozzá REST API megvalósítása PHP nyelven.
A rendszerben feladókat (felhasználókat) és csomagokat kezelünk.

A feladatot meg lehet oldani PHP keretrendszer nélkül is, nagyon örülnénk, ha ilyen megoldást látnánk tőled.

### Információk

**Források**

* `users_parcels.sql` a kezdeti MySQL/MariaDB adatbázistáblák (felhasználók és csomagok)
* `README.md` ez a leírás

**Mit fogunk megnézni?**

* az alkalmazás működik a leírásnak megfelelően, beleértve az adatok validálását és a formátumokat
* OOP használat

**Leadás**

A megoldást egy publikus github repositoryba töltsd fel, majd küldd el a linkjét válaszként a levélre, amiben a feladatot kaptad.
Legyenek benne az alkalmazás PHP fájljai és egyéb más fájlok, ha használ. Ha külső libraryket/csomagokat használsz, akkor mellékeld a `composer.json` fájlt is, de a `vendor` mappát nem szükséges.

### Feladat

**API**

Készíts el a két erőforráshoz (felhasználók és csomagok) két-két API végpontot. Az egyszerűség kedvéért lehet mindegyik erőforrásnak egy-egy PHP fájlja, amit meg kell hívni (pl users.php és parcels.php), vagy egyetlen fájlban (pl index.php) is kezelheted az adatok befogadását, de extra pontért gondolkozz el egy kifejezőbb URI sémában történő routingon (lásd lejjebb).

A megvalósítandó műveletek:

Felhasználók esetén:

* felhasználói lista lekérdezése `GET` hívással. A válaszban JSON formátumban egy tömbben adja vissza az alkalmazás az összes felhasználó adatait, kivéve a jelszavukat. 
Példa válasz a forrásfájl alapján:

	```
	[
	  {
	    "id": 1,
	    "first_name": "Zsombor",
	    "last_name": "Balogh",
	    "email_address": "zsombor.balogh@moonproject.io",
	    "phone_number": null
	  },
	  {
	    "id": 3,
	    "first_name": "Jenő",
	    "last_name": "Polgár",
	    "email_address": "jeno.polgar@moonproject.io",
	    "phone_number": "+36203114566"
	  },
	  {
	    "id": 4,
	    "first_name": "Mátyás",
	    "last_name": "Király",
	    "email_address": "matyas.kiraly@moonproject.io",
	    "phone_number": null
	  }
	]
	```

- felhasználó hozzáadása `POST` hívással. A művelet JSON formátumban várja az új felhasználó adatait (keresztnév, vezetéknév, email cím, jelszó és __nem kötelezően__ telefonszám). A jelszót [Bcrypt-tel hashelt](https://www.php.net/manual/en/function.password-hash.php) formátumban tárold. 
Sikeres mentés után válaszban add vissza a felhasználó objektumot a jelszó mező nélkül:

	```
	  {
	    "id": 5,
	    "first_name": "Kázmér",
	    "last_name": "Kovács",
	    "email_address": "kazmer.kovacs@moonproject.io",
	    "phone_number": "+36302131886"
	  }
	```

Csomagok esetén:

- egy darab csomag adatainak lekérdezése `GET` metódussal. A paraméterként kapott csomagszám (parcel_number) alapján a csomag adatainak és annak a felhasználónak a visszaadása, akihez tartozik. A felhasználó adatainál a jelszó mezőt itt se add vissza. Példa válasz:

	```
    {
        "id": 1,
        "parcel_number": "850f6335d7",
        "size": "M",
        "user": {
                "id": 3,
                "first_name": "Jenő",
                "last_name": "Polgár",
                "email_address": "jeno.polgar@moonproject.io",
                "phone_number": "+36203114566"
        }
    }
	```

- egy csomag hozzáadása `POST` metódussal. A kérésben JSON formátumban kapott adatokkal (size, user_id) beszúr egy új csomagot az adatbázisba. A méret `S`, `M`, `L` vagy `XL` érték lehet csak. A csomagszámot az alkalmazásnak kell generálnia a beszúrt csomaghoz, úgy, hogy az egy egyedi, hexadecimális, 10 karakter hosszúságú string legyen. Sikeres mentés után válaszban add vissza a csomag objektumot a hozzá tartozó felhasználóval (természetesen a jelszó mező nélkül), mint az előző lekérdező hívásnál.

**Dokumentáció**

Készíts el egy nagyon rövid dokumentációt az alkalmazáshoz, ahol leírod, hogy milyen URI-kon milyen bemenetet vár, illetve mi szükséges a futtatásához.

**Extra pontok**

Néhány további feladat, amit megcsinálhatsz, ha kedved és időd tartja.

* routing megvalósítása a következő URI-kra:
	* `GET` `/users` felhasználók lekérdezése
	* `POST` `/users` felhasználó hozzáadása
	* `GET` `/parcels/{parcel_number}` csomag lekérdezése
	* `POST` `/parcels` csomag hozzáadása
* megfelelő HTTP státuszkódok használata siker és különböző hibák esetén, válaszban megfelelő hibaüzenettel

Nyugodtan keress minket, ha valami részlet nem teljesen érthető a feladatban.

Jó munkát,
a MoonLabs csapata
