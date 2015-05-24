# simple-shariff-backend-php

Ein simples PHP Backend für
 [https://github.com/heiseonline/shariff](https://github.com/heiseonline/shariff), das ohne zusätzliche PHP Bibliotheken auskommt. 

Diese Bibliothek ist kompatibel bis PHP 5.3, vielleicht auch zu älteren Versionen. 

[![Build Status](https://travis-ci.org/phpmonkeys-de/simple-shariff-backend-php.svg?branch=master)](https://travis-ci.org/phpmonkeys-de/simple-shariff-backend-php)

## Wer sollte diese Bibliothek nutzen
Diese Implementierung unterscheidet sich zu der bestehenden Shariff PHP Backend Implementierung dadurch, dass sie nicht PHP 5.4 voraussetzt. Es gibt ältere Server Systeme (bspw Ubuntu 10.04 LTS), die auf PHP 5.3 fest sitzen und auf diesen funktioniert die Originalbibliothek leider nicht. Wenn man nicht seinen Server upgraden möchte/kann muss man eine alternative Implementierung wie die vorliegende nutzen.

## Gibt es Besonderheiten?
Ja. PHP muss mit JSON und curl Support kompiliert sein, weil das simple Backend immerhin Abhängigkeiten zu diesen "Systembibliotheken" hat.

Noch etwas?
Na, es werden alle Services des Original-Backend unterstützt. Aber machen Implementierung sind anders als im Original. Zum Beispiel wurden die Facebook- und Flattr-Services anders implementiert. Aus Spaß wurde auch noch Unterstützung für VKontakte hinzugefügt.
Falls ein Service fehlt, dann freue ich mich über einen Pull Request. Oder öffne einfach einen Issue.

### Facebook Implementierung
Die vorliegende Implementierung benutzt die Graph API in der Version 2.3 um die Anzahl der Shares abzurufen. Hierfür wird aber eine App Id und ein App Secret benötigt, damit die Server zu Server Kommunikation zu Facebook durchgeführt werden kann. Es wurde die Graph API 2.3 gewählt, weil diese die neuste Version der API ist und alle neu erstellten Facebook Apps ausschließlich diese unterstützen.
Falls keine Facebook App in der Konfiguration angegeben wird, wird als Fallback auf einen alternativen Graph Request umgeschwenkt. Die damit bestimmt Anzahl kann aber von der anderen Methode abweichen und ist tendenziell eher ungenauer. Immerhin kann man so überhaupt eine Zahl anzeigen. In der Original-Bibliothek wird auch noch eine FQL-Implementierung angeboten, die hier aber nicht zur Verfügung steht, weil FQL nur noch in alten bestehenden Facebook Apps die Graph API 2.0 unterstützen funktioniert. Und diese Abhängigkeit ist js nicht so ganz fair gegenüber den Nutzern :smiley:

### Flattr Implementierung
Flattr gibt bei der Suche nach einer url ein JSON zurück indem eine weitere URL zur eigentlichen Resource steht. Die "simple Backend"-Implementierung löst diese ebenfalls auf und liefert den Flattr Wert dann zurück, der in dem JSON enthalten ist, das im zweiten Schritt geladen wurde.

## Testen
Für jeden Service gibt es einen Integrtionstest.

## Benutzung
Die Benutzung ist wirklich einfach. Man muss nur den Inhalt des `src` Ordners auf den eigenen Server kopieren (und nicht die Unterordner vergessen).

Jetz muss man noch die `config.sample.php` in die `config.php` umkopieren und die Konfiguration anpassen. Hier kann man die Services an- oder abschalten (normalerweise sind alle Services angeschaltet). Die Caching Zeit anpassen und die API Keys für Google+ und Facebook setzen.

Der Cache kann deaktiviert werde, wenn man beispielsweise die Funktion testen oder debuggen möchte. Aber im Produktivbetrieb sollte der Cache aktiv sein, da die Calls zu den Service URLs nicht sonderlich schnell sind.

Weiterhin sollte man den `hostfilter` setzen. Dieser verhindert, dass Informationen über URLs abgerufen werden, die nicht zu dem eigenen Server gehören. Man muss nur SUbdomäne und Domäne angeben, das Protokoll (http/https) wird nicht benötigt und stört sogar.

Der Webserver muss jetzt noch in das `cache` Verzeichnis schreiben können. Sonst ist es nicht möglich die Cache Dateien anzulegen.

Nun kann man schon das Skript aufrufen und am besten ein Request-Parameter `url` mit einer URL mitgeben, deren Informationen man abrufen möchte.

```bash
http://example.org/shariff-backend/index.php?url=http://example.org/myReallyGreatArticle.html
```
Man erhält ein JSON, das dem der Original-Implementierung entspricht.

## TODO
* Fehlerbehandlung fehlt noch
* Caching verbessern