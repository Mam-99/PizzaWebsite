---
name: Checkliste Praktikum 2
about: Template zur Bewertung des Praktikums

---

# Abgabe
- [ ] Das Verzeichnis enthält nur die erwarteten Dateien

# Bewertung Code
- [ ] Klasse Page.php: Vollständig ausgefüllt? Destruktor?
- [ ] Datenbankzugriff mit Dockerunterstützung und mit User public?
- [ ] Implementierung der Seiten Bestellung.php, Kunde.php, Baecker.php und Fahrer.php mittels Seitenklassen? 
- [ ] Freigabe des RecordSets nach der Nutzung?
- [ ] Rückgabe der Daten aus getViewData als Array?
- [ ] Datenbankzugriffe mittels MySQLi implementiert? 
- [ ] Fahrer: Abschicken der Daten mit POST? isset vor Zugriffen auf POST-Variablen?

# Bewertung Funktion
- [ ] Die "Speisekarte" auf der Bestellseite wird mit den Daten aus den Datenbank erzeugt (z.B. Spinat-Hühnchen für 11.99)? 
- [ ] Die Daten, welche die Bestellseite abschickt, werden in der Datenbank abgelegt? (Bestellung abschicken->erscheint neu auf Kundenseite!?)

- [ ] Die Kundenseite zeigt (noch) *alle* bestellten Pizzen?  (Die Einschränkung auf die Pizzen des jeweiligen Kunden erfolgt erst in der nächsten Übung durch Sessionmanagement.) 

- [ ] Die Bäckerseite zeigt die bestellten Pizzen? 
- [ ] Der Bäcker kann den Status einer Pizza mit einem Submit-Button abschicken. Die Änderung wird in die Datenbank übernommen? 
- [ ] Die Bäckerseite aktualisiert sich alle 5 Sekunden?
- [ ] Die Bäckerseite zeigt eine Meldung, wenn nichts zu tun ist? (keinen Fehler!)
- [ ] Pizzen verschwinden (erst) beim Bäcker, wenn der Fahrer sie auf *unterwegs* setzt?

- [ ] Die Fahrerseite aktualisiert sich alle 5 Sekunden?
- [ ] Die Fahrerseite zeigt nur (!) die Bestellungen, die bereit für die Auslieferung sind (Default: Birkenweg 7...).
- [ ] Die Fahrerseite zeigt den Gesamtpreis und die Lieferadresse der Bestellung an?
- [ ] Keine Post-Blockade bei Reload (F5 auf Fahrerseite ohne Popup) (*PRG-Pattern*)?
- [ ] Der Fahrer kann den Status einer Bestellung ändern und mit einem Submit-Button abschicken. Die Änderung wird in die Datenbank übernommen? 
- [ ] Ausgelieferte Bestellungen verschwinden beim Fahrer?
- [ ] Die Fahrerseite zeigt eine Meldung, wenn keine Lieferung ansteht? (keinen Fehler!)

# Bemerkungen
- 
