---
name: Checkliste Praktikum 4
about: Template zur Bewertung des Praktikums

---

# Abgabe
- [ ] Das Verzeichnis enthält die erwarteten Dateien in einer sinnvollen Struktur?

# Bewertung der Funktion
Vorher: Eine neue Pizza in die DB einfügen: "#EWASGRT", 4.17€, pizza.gif
- [ ] Bestellseite: Neue Pizza erscheint im Angebot? 
- [ ] Einfügen von Pizzen (Anklicken) in den Warenkorb funktioniert? 
- [ ] "Alle Pizzen löschen" funktioniert?
- [ ] Funktion "mehrere Löschen" funktioniert korrekt (Aus der Folge A,A,B,B,C,C die Pizzen B,B löschen)?
- [ ] Preis wird korrekt berechnet während Einfügen und Löschen?
- [ ] Preise sind ordentlich formatiert mit Euro-Zeichen (. statt , ist in Ordnung)?
- [ ] Mehrfaches Einfügen und Löschen einer Pizza mit dem Preis 11.99 bzw. 8.57 funktioniert ohne Rundungsfehler?
- [ ] (De)aktivieren des Bestellknopfs in Abhängigkeit von Adresse und Warenkorb funktioniert?

Jetzt: Bestellung mit Adresse \<h1\>Hallo\</h1\> durchführen
- [ ] Bestellte Pizzen (erscheinen im Kundenstatus)?
- [ ] Beim Bäcker eine Pizza ändern: Aktualisierung der Bestellung mit AJAX funktioniert im Kundenstatus?
- [ ] Übergabe der Pizzen zwischen Fahrer und Bäcker korrekt?
- [ ] Korrektes Verhalten, wenn die Pizza ausgeliefert wurde (kein Fehler / defektes Layout)?
- [ ] Bäcker und Fahrer: Submit-Button entfernt und Abschicken mit Radiobuttons möglich?
- [ ] Fahrerseite zeigt \<h1\>Hallo\</h1\> als Adresse an? 
- [ ] Erwartete Inhalte auf den Seiten?

# Bewertung Code
- [ ] Erzeugter HTML-Code ist valide und besteht den HTML-Lint (Fehler wegen leerem Select it OK)?
- [ ] JavaScript: use strict in allen Functionen?
- [ ] Strukturierter / ordentlicher JS-Code? 
- [ ] ESLint findet keine Fehler (Rules: ECMA 2019, Enable global environment) bis auf never-used für Methoden die in HTML aufgerufen werden?
- [ ] Keine Verwendung von innerHTML?
- [ ] Klasse verwendet? (Nicht verpflichtend, eher Ehrenkodex für Informatiker)?
- [ ] Vollständige Implementierung der zyklischen Aktualisierung der Kundenseite über AJAX und JSON? 

# Bemerkung
- 

