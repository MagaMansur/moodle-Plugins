// Warten, bis die komplette HTML-Seite geladen ist
document.addEventListener('DOMContentLoaded', function() {
    
    // Prüfen, ob Winwheel geladen ist und Teilnehmer existieren
    if (typeof Winwheel === 'undefined' || !participants) return;

    // Canvas-Element für das Roulette-Rad erstellen
    const canvas = document.createElement('canvas');
    canvas.id = 'rouletteWheel';  // ID für Winwheel
    canvas.width = 500;            // Breite des Rads
    canvas.height = 500;           // Höhe des Rads
    document.getElementById('roulette-container').appendChild(canvas); // In Container einfügen

    // Neues Winwheel erstellen
    const wheel = new Winwheel({
        'canvasId': 'rouletteWheel',               // ID des Canvas
        'numSegments': participants.length,        // Anzahl der Segmente = Anzahl der Teilnehmer
        'outerRadius': 230,                         // Radius des Rads
        // Segmente erstellen, jedes bekommt zufällige Farbe und den Namen eines Teilnehmers
        'segments': participants.map(name => ({ 
            'fillStyle': randomColor(), 
            'text': name 
        })),
        // Animationseinstellungen
        'animation': {
            'type': 'spinToStop',                  // Animation: Drehen bis zum Stop
            'duration': 5,                          // Dauer in Sekunden
            'spins': 8,                             // Anzahl der kompletten Drehungen
            'callbackFinished': announceWinner     // Funktion, die aufgerufen wird, wenn das Rad stoppt
        }
    });

    // Event-Listener für den „Drehen“-Button
    document.getElementById('spin-button').addEventListener('click', () => {
        wheel.stopAnimation(false); // Stopp alte Animation, falls noch aktiv
        wheel.rotationAngle = 0;    // Zurücksetzen auf Anfangsposition
        wheel.startAnimation();     // Start der Dreh-Animation
    });

    // Funktion, die aufgerufen wird, wenn das Rad angehalten hat
    function announceWinner(segment) {
        alert('Student: ' + segment.text); // Gewinner-Namen anzeigen
        document.getElementById("demo").innerHTML = "My First JavaScript";
    }

    // Funktion, die eine zufällige Farbe generiert
    function randomColor() {
        const letters = '789ABCD'; // Helle/farbkräftige Buchstaben
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * letters.length)];
        }
        return color; // Rückgabe z. B. "#7A9BCD"
    }
});
