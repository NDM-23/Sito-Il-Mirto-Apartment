# Immagini del sito

Questa cartella contiene le immagini campione locali usate dal sito.

Per modificarle:

1. Sostituisci un file mantenendo lo stesso nome, ad esempio `hero-piscina-sardegna.svg`, e il sito userà automaticamente la nuova immagine.
2. In alternativa, aggiungi una nuova immagine in questa cartella e aggiorna il percorso nelle pagine Blade dentro `resources/views/site/`.
3. Per la galleria caricata dai dati iniziali, aggiorna l'elenco `$sampleGalleryImages` in `database/seeders/DatabaseSeeder.php`.

I percorsi pubblici partono da `/images/site/`, per esempio:

```blade
{{ asset('images/site/hero-piscina-sardegna.svg') }}
```

Le immagini attuali sono SVG campione: puoi sostituirle con file `.jpg`, `.png`, `.webp` o `.svg` usando lo stesso nome oppure aggiornando i riferimenti nel codice.
