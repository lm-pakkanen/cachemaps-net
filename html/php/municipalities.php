<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);

$municipalities = array(
  "Akaa",
  "Alajärvi",
  "Alavieska",
  "Alavus",
  "Asikkala",
  "Askola",
  "Aura",
  "Brändö",
  "Eckerö",
  "Enonkoski",
  "Enontekiö",
  "Espoo",
  "Eura",
  "Eurajoki",
  "Evijärvi",
  "Finström",
  "Forssa",
  "Föglö",
  "Geta",
  "Haapajärvi",
  "Haapavesi",
  "Hailuoto",
  "Halsua",
  "Hamina",
  "Hammarland",
  "Hankasalmi",
  "Hanko",
  "Harjavalta",
  "Hartola",
  "Hattula",
  "Hausjärvi",
  "Heinola",
  "Heinävesi",
  "Helsinki",
  "Hirvensalmi",
  "Hollola",
  "Honkajoki",
  "Huittinen",
  "Humppila",
  "Hyrynsalmi",
  "Hyvinkää",
  "Hämeenkyrö",
  "Hämeenlinna",
  "Ii",
  "Iisalmi",
  "Iitti",
  "Ikaalinen",
  "Ilmajoki",
  "Ilomantsi",
  "Imatra",
  "Inari",
  "Inkoo",
  "Isojoki",
  "Isokyrö",
  "Janakkala",
  "Joensuu",
  "Jokioinen",
  "Jomala",
  "Joroinen",
  "Joutsa",
  "Juuka",
  "Juupajoki",
  "Juva",
  "Jyväskylä",
  "Jämijärvi",
  "Jämsä",
  "Järvenpää",
  "Kaarina",
  "Kaavi",
  "Kajaani",
  "Kalajoki",
  "Kangasala",
  "Kangasniemi",
  "Kankaanpää",
  "Kannonkoski",
  "Kannus",
  "Karijoki",
  "Karkkila",
  "Karstula",
  "Karvia",
  "Kaskinen",
  "Kauhajoki",
  "Kauhava",
  "Kauniainen",
  "Kaustinen",
  "Keitele",
  "Kemi",
  "Kemijärvi",
  "Keminmaa",
  "Kemiönsaari",
  "Kempele",
  "Kerava",
  "Keuruu",
  "Kihniö",
  "Kinnula",
  "Kirkkonummi",
  "Kitee",
  "Kittilä",
  "Kiuruvesi",
  "Kivijärvi",
  "Kokemäki",
  "Kokkola",
  "Kolari",
  "Konnevesi",
  "Kontiolahti",
  "Korsnäs",
  "KoskiTl",
  "Kotka",
  "Kouvola",
  "Kristiinankaupunki",
  "Kruunupyy",
  "Kuhmo",
  "Kuhmoinen",
  "Kumlinge",
  "Kuopio",
  "Kuortane",
  "Kurikka",
  "Kustavi",
  "Kuusamo",
  "Kyyjärvi",
  "Kärkölä",
  "Kärsämäki",
  "Kökar",
  "Lahti",
  "Laihia",
  "Laitila",
  "Lapinjärvi",
  "Lapinlahti",
  "Lappajärvi",
  "Lappeenranta",
  "Lapua",
  "Laukaa",
  "Lemi",
  "Lemland",
  "Lempäälä",
  "Leppävirta",
  "Lestijärvi",
  "Lieksa",
  "Lieto",
  "Liminka",
  "Liperi",
  "Lohja",
  "Loimaa",
  "Loppi",
  "Loviisa",
  "Luhanka",
  "Lumijoki",
  "Lumparland",
  "Luoto",
  "Luumäki",
  "Maalahti",
  "Maarianhamina",
  "Marttila",
  "Masku",
  "Merijärvi",
  "Merikarvia",
  "Miehikkälä",
  "Mikkeli",
  "Muhos",
  "Multia",
  "Muonio",
  "Mustasaari",
  "Muurame",
  "Mynämäki",
  "Myrskylä",
  "Mäntsälä",
  "Mänttä-Vilppula",
  "Mäntyharju",
  "Naantali",
  "Nakkila",
  "Nivala",
  "Nokia",
  "Nousiainen",
  "Nurmes",
  "Nurmijärvi",
  "Närpiö",
  "Orimattila",
  "Oripää",
  "Orivesi",
  "Oulainen",
  "Oulu",
  "Outokumpu",
  "Padasjoki",
  "Paimio",
  "Paltamo",
  "Parainen",
  "Parikkala",
  "Parkano",
  "Pedersörenkunta",
  "Pelkosenniemi",
  "Pello",
  "Perho",
  "Pertunmaa",
  "Petäjävesi",
  "Pieksämäki",
  "Pielavesi",
  "Pietarsaari",
  "Pihtipudas",
  "Pirkkala",
  "Polvijärvi",
  "Pomarkku",
  "Pori",
  "Pornainen",
  "Porvoo",
  "Posio",
  "Pudasjärvi",
  "Pukkila",
  "Punkalaidun",
  "Puolanka",
  "Puumala",
  "Pyhtää",
  "Pyhäjoki",
  "Pyhäjärvi",
  "Pyhäntä",
  "Pyhäranta",
  "Pälkäne",
  "Pöytyä",
  "Raahe",
  "Raasepori",
  "Raisio",
  "Rantasalmi",
  "Ranua",
  "Rauma",
  "Rautalampi",
  "Rautavaara",
  "Rautjärvi",
  "Reisjärvi",
  "Riihimäki",
  "Ristijärvi",
  "Rovaniemi",
  "Ruokolahti",
  "Ruovesi",
  "Rusko",
  "Rääkkylä",
  "Saarijärvi",
  "Salla",
  "Salo",
  "Saltvik",
  "Sastamala",
  "Sauvo",
  "Savitaipale",
  "Savonlinna",
  "Savukoski",
  "Seinäjoki",
  "Sievi",
  "Siikainen",
  "Siikajoki",
  "Siikalatva",
  "Siilinjärvi",
  "Simo",
  "Sipoo",
  "Siuntio",
  "Sodankylä",
  "Soini",
  "Somero",
  "Sonkajärvi",
  "Sotkamo",
  "Sottunga",
  "Sulkava",
  "Sund",
  "Suomussalmi",
  "Suonenjoki",
  "Sysmä",
  "Säkylä",
  "Taipalsaari",
  "Taivalkoski",
  "Taivassalo",
  "Tammela",
  "Tampere",
  "Tervo",
  "Tervola",
  "Teuva",
  "Tohmajärvi",
  "Toholampi",
  "Toivakka",
  "Tornio",
  "Turku",
  "Tuusniemi",
  "Tuusula",
  "Tyrnävä",
  "Ulvila",
  "Urjala",
  "Utajärvi",
  "Utsjoki",
  "Uurainen",
  "Uusikaarlepyy",
  "Uusikaupunki",
  "Vaala",
  "Vaasa",
  "Valkeakoski",
  "Valtimo",
  "Vantaa",
  "Varkaus",
  "Vehmaa",
  "Vesanto",
  "Vesilahti",
  "Veteli",
  "Vieremä",
  "Vihti",
  "Viitasaari",
  "Vimpeli",
  "Virolahti",
  "Virrat",
  "Vårdö",
  "Vöyri",
  "Ylitornio",
  "Ylivieska",
  "Ylöjärvi",
  "Ypäjä",
  "Ähtäri",
  "Äänekoski"
);