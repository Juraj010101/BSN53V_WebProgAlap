<!DOCTYPE html>

<html lang="hu">

    <head>
        <meta charset="UTF-8">
        <title>BL_Feldolgozó3</title>
    </head>
    
    <body>
        <?php
        
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
                 echo "<h2>HTML űrlap</h2>";
        
        // Űrlapadatok beolvasása
        $nev = htmlspecialchars(trim($_POST["nev"] ?? ""));
        $pin = htmlspecialchars(trim($_POST["pin"] ?? ""));
        $fav_fruit = htmlspecialchars(trim($_POST["fav_fruit"] ?? "Nincs megadva"));
        $age = htmlspecialchars(trim($_POST["age"] ?? "Nincs megadva"));
        $feet_size = htmlspecialchars(trim($_POST["feet_size"] ?? "Nincs megadva"));
        $confidence = htmlspecialchars(trim($_POST["confidence"] ?? "Nincs megadva"));

        // Egyszerű validáció szerveroldalon
        $hibak = [];
        if (!preg_match("/^[A-ZÁÉÍÓÖŐÚÜŰa-záéíóöőúüű ]{4,}$/u", $nev)) {
            $hibak[] = "A név formátuma hibás.";
        }
        if (!preg_match("/^[0-9]{4}$/", $pin)) {
            $hibak[] = "A PIN kód 4 számjegyből kell álljon.";
        }

        // Hibák megjelenítése vagy adatok kiírása
        if (count($hibak) > 0) {
            echo "<div class='error'><p><strong>Hiba történt:</strong></p><ul>";
            foreach ($hibak as $hiba) {
                echo "<li>$hiba</li>";
            }
            echo "</ul></div>";
        } else {
            
        // Adatok táblázatos megjelenítése
            echo "<table>";
                echo "<tr><td>Név:</td><td>$nev</td></tr>";
                echo "<tr><td>PIN kód:</td><td>$pin</td></tr>";
                echo "<tr><td>Kedvenc gyümölcs:</td><td>$fav_fruit</td></tr>";
                echo "<tr><td>Életkor:</td><td>$age</td></tr>";
                echo "<tr><td>Lábméret:</td><td>$feet_size</td></tr>";
                echo "<tr><td>Önbizalom:</td><td>$confidence / 100</td></tr>";
            echo "</table>";

        // --- Fájlba mentés ---
            $sor = date("Y-m-d H:i:s") . " | " .
                   "Név: $nev | " .
                   "PIN: $pin | " .
                   "Kedvenc gyümölcs: $fav_fruit | " .
                   "Életkor: $age | " .
                   "Lábméret: $feet_size | " .
                   "Önbizalom: $confidence" . PHP_EOL;

            $fajl = "BSN53V.txt";

            if (file_put_contents($fajl, $sor, FILE_APPEND | LOCK_EX)) {
                echo "<p class='success'>✅ Az adatok sikeresen elmentve a <strong>$fajl</strong> fájlba.</p>";
            } else {
                echo "<p class='error'>⚠ Hiba történt az adatok mentésekor!</p>";
            }
        }
    } else {
        echo "<p class='error'>Nem POST metódussal érkezett az űrlap.</p>";
    }
    
    ?>

        <a href="BL_urlap.html"><strong>Vissza az űrlapra.</strong></a>
    </body>
    
</html>