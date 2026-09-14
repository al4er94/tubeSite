<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\ImageTranslation;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            [
                'path'            => 'images/1.jpg',
                'slug'            => 'mountain-peaks-at-sunset',
                'category_slugs'  => ['mountains', 'landscapes'],
                'views'           => 1243,
                'likes'           => 87,
                'translations' => [
                    'en' => [
                        'title'       => 'Mountain peaks at sunset',
                        'description' => 'A breathtaking view of snow-capped mountain peaks bathed in the warm golden light of the setting sun.',
                        'keywords'    => ['mountains', 'sunset', 'snow', 'peaks', 'landscape', 'nature'],
                    ],
                    'ru' => [
                        'title'       => 'Горные вершины на закате',
                        'description' => 'Захватывающий вид на заснеженные горные вершины, залитые тёплым золотистым светом заходящего солнца.',
                        'keywords'    => ['горы', 'закат', 'снег', 'вершины', 'пейзаж', 'природа'],
                    ],
                    'de' => [
                        'title'       => 'Berggipfel bei Sonnenuntergang',
                        'description' => 'Ein atemberaubender Blick auf schneebedeckte Berggipfel, die im warmen goldenen Licht der untergehenden Sonne leuchten.',
                        'keywords'    => ['Berge', 'Sonnenuntergang', 'Schnee', 'Gipfel', 'Landschaft', 'Natur'],
                    ],
                    'fr' => [
                        'title'       => 'Sommets montagneux au coucher du soleil',
                        'description' => 'Une vue époustouflante sur des sommets enneigés baignés dans la chaude lumière dorée du soleil couchant.',
                        'keywords'    => ['montagnes', 'coucher de soleil', 'neige', 'sommets', 'paysage', 'nature'],
                    ],
                ],
            ],
            [
                'path'            => 'images/2.jpg',
                'slug'            => 'forest-path-in-the-mist',
                'category_slugs'  => ['forests'],
                'views'           => 874,
                'likes'           => 52,
                'translations' => [
                    'en' => [
                        'title'       => 'Forest path in the mist',
                        'description' => 'A mysterious trail winds through a dense forest shrouded in morning mist, inviting the wanderer deeper into the wilderness.',
                        'keywords'    => ['forest', 'mist', 'trail', 'morning', 'wilderness', 'nature'],
                    ],
                    'ru' => [
                        'title'       => 'Лесная тропа в тумане',
                        'description' => 'Таинственная тропинка вьётся сквозь густой лес, окутанный утренним туманом, маня путника вглубь дикой природы.',
                        'keywords'    => ['лес', 'туман', 'тропа', 'утро', 'природа', 'дикий лес'],
                    ],
                    'de' => [
                        'title'       => 'Waldweg im Nebel',
                        'description' => 'Ein geheimnisvoller Pfad schlängelt sich durch einen dichten, in Morgennebel gehüllten Wald und lockt den Wanderer tiefer in die Wildnis.',
                        'keywords'    => ['Wald', 'Nebel', 'Pfad', 'Morgen', 'Wildnis', 'Natur'],
                    ],
                    'fr' => [
                        'title'       => 'Sentier forestier dans le brouillard',
                        'description' => 'Un sentier mystérieux serpente à travers une forêt dense enveloppée de brume matinale, invitant le promeneur à s\'enfoncer dans la nature sauvage.',
                        'keywords'    => ['forêt', 'brouillard', 'sentier', 'matin', 'nature sauvage', 'nature'],
                    ],
                ],
            ],
            [
                'path'            => 'images/3.jpg',
                'slug'            => 'calm-sea-at-dawn',
                'category_slugs'  => ['sea-and-ocean'],
                'views'           => 2105,
                'likes'           => 134,
                'translations' => [
                    'en' => [
                        'title'       => 'Calm sea at dawn',
                        'description' => 'The sea lies perfectly still at the break of dawn, its glassy surface reflecting pastel hues of pink and orange from the horizon.',
                        'keywords'    => ['sea', 'dawn', 'ocean', 'calm', 'sunrise', 'reflection'],
                    ],
                    'ru' => [
                        'title'       => 'Спокойное море на рассвете',
                        'description' => 'На рассвете море лежит в полном безмолвии, его зеркальная поверхность отражает пастельные розово-оранжевые тона горизонта.',
                        'keywords'    => ['море', 'рассвет', 'океан', 'спокойствие', 'восход', 'отражение'],
                    ],
                    'de' => [
                        'title'       => 'Ruhiges Meer bei Morgengrauen',
                        'description' => 'Das Meer liegt im Morgengrauen vollkommen still, seine spiegelglatte Oberfläche reflektiert die pastellfarbenen Rosa- und Orangetöne am Horizont.',
                        'keywords'    => ['Meer', 'Morgengrauen', 'Ozean', 'Ruhe', 'Sonnenaufgang', 'Spiegelung'],
                    ],
                    'fr' => [
                        'title'       => 'Mer calme à l\'aube',
                        'description' => 'La mer est parfaitement immobile à l\'aube, sa surface lisse comme un miroir reflétant les teintes pastel roses et orangées de l\'horizon.',
                        'keywords'    => ['mer', 'aube', 'océan', 'calme', 'lever du soleil', 'reflet'],
                    ],
                ],
            ],
            [
                'path'            => 'images/4.jpg',
                'slug'            => 'green-hills-in-summer',
                'category_slugs'  => ['landscapes', 'forests'],
                'views'           => 631,
                'likes'           => 41,
                'translations' => [
                    'en' => [
                        'title'       => 'Green hills in summer',
                        'description' => 'Lush rolling hills covered in vibrant green grass stretch endlessly under a bright summer sky dotted with fluffy white clouds.',
                        'keywords'    => ['hills', 'summer', 'green', 'meadow', 'landscape', 'clouds'],
                    ],
                    'ru' => [
                        'title'       => 'Зелёные холмы летом',
                        'description' => 'Пышные холмистые луга, покрытые ярко-зелёной травой, уходят вдаль под ярким летним небом с пушистыми белыми облаками.',
                        'keywords'    => ['холмы', 'лето', 'зелень', 'луга', 'пейзаж', 'облака'],
                    ],
                    'de' => [
                        'title'       => 'Grüne Hügel im Sommer',
                        'description' => 'Üppige, sanft geschwungene Hügel, bedeckt mit sattem grünen Gras, erstrecken sich endlos unter einem strahlend blauen Sommerhimmel mit weißen Wolken.',
                        'keywords'    => ['Hügel', 'Sommer', 'grün', 'Wiese', 'Landschaft', 'Wolken'],
                    ],
                    'fr' => [
                        'title'       => 'Collines vertes en été',
                        'description' => 'De luxuriantes collines ondulantes couvertes d\'une herbe verte vibrante s\'étendent à l\'infini sous un ciel d\'été lumineux parsemé de nuages blancs et duveteux.',
                        'keywords'    => ['collines', 'été', 'vert', 'prairie', 'paysage', 'nuages'],
                    ],
                ],
            ],
            [
                'path'            => 'images/5.jpg',
                'slug'            => 'waterfall-in-the-mountains',
                'category_slugs'  => ['mountains', 'forests'],
                'views'           => 1788,
                'likes'           => 119,
                'translations' => [
                    'en' => [
                        'title'       => 'Waterfall in the mountains',
                        'description' => 'A powerful waterfall cascades down rugged mountain rocks, sending a fine mist into the cool alpine air and nourishing the moss below.',
                        'keywords'    => ['waterfall', 'mountains', 'rocks', 'alpine', 'water', 'nature'],
                    ],
                    'ru' => [
                        'title'       => 'Водопад в горах',
                        'description' => 'Мощный водопад низвергается по суровым горным скалам, наполняя прохладный горный воздух мелкими брызгами и питая мох внизу.',
                        'keywords'    => ['водопад', 'горы', 'скалы', 'альпы', 'вода', 'природа'],
                    ],
                    'de' => [
                        'title'       => 'Wasserfall in den Bergen',
                        'description' => 'Ein mächtiger Wasserfall stürzt über raue Felsbrocken hinab, versprüht feinen Nebel in die kühle Bergluft und nährt das Moos darunter.',
                        'keywords'    => ['Wasserfall', 'Berge', 'Felsen', 'Alpen', 'Wasser', 'Natur'],
                    ],
                    'fr' => [
                        'title'       => 'Cascade en montagne',
                        'description' => 'Une puissante cascade dévale les rochers escarpés de la montagne, envoyant une fine bruine dans l\'air frais des alpages et nourrissant la mousse en contrebas.',
                        'keywords'    => ['cascade', 'montagnes', 'rochers', 'alpes', 'eau', 'nature'],
                    ],
                ],
            ],
            [
                'path'            => 'images/6.jpg',
                'slug'            => 'aerial-view',
                'category_slugs'  => ['landscapes', 'mountains'],
                'views'           => 956,
                'likes'           => 73,
                'translations' => [
                    'en' => [
                        'title'       => 'Aerial view',
                        'description' => 'A stunning bird\'s-eye perspective reveals the intricate patterns of the landscape below, where fields, rivers and roads form a living mosaic.',
                        'keywords'    => ['aerial', 'birds eye', 'landscape', 'fields', 'rivers', 'mosaic'],
                    ],
                    'ru' => [
                        'title'       => 'Вид с высоты птичьего полёта',
                        'description' => 'Потрясающий вид сверху открывает замысловатые узоры ландшафта: поля, реки и дороги складываются в живую мозаику.',
                        'keywords'    => ['аэросъёмка', 'вид сверху', 'пейзаж', 'поля', 'реки', 'мозаика'],
                    ],
                    'de' => [
                        'title'       => 'Luftansicht',
                        'description' => 'Eine atemberaubende Vogelperspektive enthüllt die komplexen Muster der Landschaft darunter, wo Felder, Flüsse und Straßen ein lebendiges Mosaik bilden.',
                        'keywords'    => ['Luftansicht', 'Vogelperspektive', 'Landschaft', 'Felder', 'Flüsse', 'Mosaik'],
                    ],
                    'fr' => [
                        'title'       => 'Vue aérienne',
                        'description' => 'Une perspective aérienne époustouflante révèle les motifs complexes du paysage en contrebas, où champs, rivières et routes forment une mosaïque vivante.',
                        'keywords'    => ['vue aérienne', 'vue de dessus', 'paysage', 'champs', 'rivières', 'mosaïque'],
                    ],
                ],
            ],
            [
                'path'            => 'images/7.jpg',
                'slug'            => 'snowy-mountain-night',
                'category_slugs'  => ['mountains', 'landscapes', 'forests'],
                'views'           => 1540,
                'likes'           => 102,
                'translations' => [
                    'en' => [
                        'title'       => 'Snowy mountain at night',
                        'description' => 'A snow-covered mountain peak rises majestically under a star-filled sky, with a pine forest silhouetted in the foreground.',
                        'keywords'    => ['snow', 'mountain', 'night', 'stars', 'pine forest', 'winter'],
                    ],
                    'ru' => [
                        'title'       => 'Заснеженная гора ночью',
                        'description' => 'Заснеженная горная вершина величественно возвышается под усыпанным звёздами небом, а хвойный лес тёмным силуэтом выделяется на переднем плане.',
                        'keywords'    => ['снег', 'гора', 'ночь', 'звёзды', 'хвойный лес', 'зима'],
                    ],
                    'de' => [
                        'title'       => 'Verschneiter Berg bei Nacht',
                        'description' => 'Ein schneebedeckter Berggipfel erhebt sich majestätisch unter einem sternklaren Himmel, während ein Kiefernwald im Vordergrund als Silhouette zu sehen ist.',
                        'keywords'    => ['Schnee', 'Berg', 'Nacht', 'Sterne', 'Kiefernwald', 'Winter'],
                    ],
                    'fr' => [
                        'title'       => 'Montagne enneigée la nuit',
                        'description' => 'Un sommet enneigé se dresse majestueusement sous un ciel étoilé, avec une forêt de pins se dessinant en silhouette au premier plan.',
                        'keywords'    => ['neige', 'montagne', 'nuit', 'étoiles', 'forêt de pins', 'hiver'],
                    ],
                ],
            ],
            [
                'path'            => 'images/8.jpg',
                'slug'            => 'tropical-beach-cove',
                'category_slugs'  => ['sea-and-ocean', 'landscapes'],
                'views'           => 2310,
                'likes'           => 178,
                'translations' => [
                    'en' => [
                        'title'       => 'Tropical beach cove',
                        'description' => 'A secluded cove with crystal-clear turquoise water is framed by lush tropical vegetation and white sandy shores.',
                        'keywords'    => ['beach', 'tropical', 'cove', 'turquoise', 'ocean', 'paradise'],
                    ],
                    'ru' => [
                        'title'       => 'Тропическая бухта',
                        'description' => 'Уединённая бухта с кристально чистой бирюзовой водой окружена пышной тропической растительностью и белоснежными песчаными берегами.',
                        'keywords'    => ['пляж', 'тропики', 'бухта', 'бирюза', 'океан', 'рай'],
                    ],
                    'de' => [
                        'title'       => 'Tropische Strandbucht',
                        'description' => 'Eine abgelegene Bucht mit kristallklarem türkisfarbenem Wasser wird von üppiger tropischer Vegetation und weißen Sandstränden eingerahmt.',
                        'keywords'    => ['Strand', 'tropisch', 'Bucht', 'türkis', 'Ozean', 'Paradies'],
                    ],
                    'fr' => [
                        'title'       => 'Crique tropicale',
                        'description' => 'Une crique isolée aux eaux turquoise cristallines est encadrée par une végétation tropicale luxuriante et des plages de sable blanc.',
                        'keywords'    => ['plage', 'tropical', 'crique', 'turquoise', 'océan', 'paradis'],
                    ],
                ],
            ],
            [
                'path'            => 'images/9.jpg',
                'slug'            => 'autumn-forest-river',
                'category_slugs'  => ['forests', 'landscapes', 'mountains'],
                'views'           => 987,
                'likes'           => 65,
                'translations' => [
                    'en' => [
                        'title'       => 'Autumn forest river',
                        'description' => 'A tranquil river meanders through an autumn forest ablaze with red and gold foliage, reflecting the fiery colours in its calm surface.',
                        'keywords'    => ['autumn', 'forest', 'river', 'foliage', 'reflection', 'fall'],
                    ],
                    'ru' => [
                        'title'       => 'Река в осеннем лесу',
                        'description' => 'Тихая река петляет сквозь осенний лес, пылающий красными и золотыми красками, отражая огненные цвета в своей спокойной глади.',
                        'keywords'    => ['осень', 'лес', 'река', 'листва', 'отражение', 'краски'],
                    ],
                    'de' => [
                        'title'       => 'Herbstlicher Waldfluss',
                        'description' => 'Ein ruhiger Fluss schlängelt sich durch einen Herbstwald, der in Rot und Gold erglüht, und spiegelt die feurigen Farben auf seiner stillen Oberfläche.',
                        'keywords'    => ['Herbst', 'Wald', 'Fluss', 'Laub', 'Spiegelung', 'Farben'],
                    ],
                    'fr' => [
                        'title'       => 'Rivière en forêt d\'automne',
                        'description' => 'Une rivière tranquille serpente à travers une forêt d\'automne embrasée de feuillages rouges et dorés, reflétant les couleurs ardentes sur sa surface calme.',
                        'keywords'    => ['automne', 'forêt', 'rivière', 'feuillage', 'reflet', 'couleurs'],
                    ],
                ],
            ],
        ];

        $categoryCache = [];

        foreach ($images as $data) {
            $image = Image::create([
                'path'  => $data['path'],
                'slug'  => $data['slug'],
                'views' => $data['views'] ?? 0,
                'likes' => $data['likes'] ?? 0,
            ]);

            foreach ($data['category_slugs'] as $slug) {
                if (! isset($categoryCache[$slug])) {
                    $categoryCache[$slug] = Category::where('slug', $slug)->value('id');
                }
                if ($categoryCache[$slug]) {
                    $image->categories()->attach($categoryCache[$slug]);
                }
            }

            foreach ($data['translations'] as $locale => $translation) {
                ImageTranslation::create([
                    'image_id'    => $image->id,
                    'locale'      => $locale,
                    'title'       => $translation['title'],
                    'description' => $translation['description'],
                    'keywords'    => $translation['keywords'] ?? [],
                ]);
            }
        }
    }
}
