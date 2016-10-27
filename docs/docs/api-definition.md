# API Definition

## Funktionen

* GET getAllPolls()

Gibt die Umfragen zurück

* GET getPollsByUser(u = username)

Gibt die Umfragen eines Benutzers zurück (Benutzer)

* POST login(u = username, p = password)

Login Funktion(Benutzername und Passwort)

* POST vote(pid = pollId, a = ids)

Funktion für Abstimmen

* GET getNewPolls(c = count)

Gibt die Neusten Umfragen zurück
