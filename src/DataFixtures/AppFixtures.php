<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function data(): array
    {
        $data = [
            [
                'name' => 'Galaxy S21 Ultra',
                'description' => "Avec son Galaxy S21 Ultra, Samsung est de retour au sommet de notre classement des meilleurs smartphones haut de gamme. 
Doté d'un incroyable écran OLED de 6,8 pouces au taux de rafraîchissement adaptatif (11-120 Hz), de performances redoutables et d'une autonomie satisfaisante, 
le Galaxy S21 Ultra coche quasiment toutes les cases. 
D'un point de vue matériel, Samsung réussit vraiment à répondre à toutes les problématiques du marché. 
Enfin, en photo, le Galaxy S21 Ultra est l'appareil le plus polyvalent du moment. Ultra grand-angle, capteur principal de 108 Mpix, zoom optique x3, 
zoom périscopique x10… Difficile de faire mieux.",
                'price' => 1259,
                'brand' => 'Samsung',
                'statut' => true
            ],
            [
                'name' => 'Find X3 Pro',
                'description' => "Comme son prédécesseur, le Oppo Find X3 Pro est excellent à tous les niveaux. 
Capable de se recharger en 42 minutes et compatible avec la recharge sans-fil, cet appareil dispose du dernier processeur haut de gamme de Qualcomm (le Snapdragon 888), 
d'un écran LTPO de dernière génération et profite d'un appareil photo de très grande qualité (même s'il ne dispose pas de zoom périscopique). 
Une nouvelle fois, Oppo nous prouve qu'il joue désormais dans la cour des grands. Le Find X3 Pro offre ce qu'il se fait de mieux sur le marché.",
                'price' => 1149,
                'brand' => 'Oppo',
                'statut' => true
            ],
            [
                'name' => 'iPhone 13 Pro Max',
                'description' => "Smartphone ultime d'Apple, l'iPhone 13 Pro Max est le smartphone le plus endurant du marché selon les mesures de notre laboratoire. 
Son petit frère, l'iPhone 13 Pro, s'en sort aussi formidablement bien. 
Tous deux équipés d'un triple module caméra de compétition (ultra grand-angle avec macro, capteur principal de 12 Mpix et zoom x3), 
très puissants (processeur A15 Bionic) et, surtout, premiers smartphones d'Apple avec un écran ProMotion (taux de rafraîchissement adaptatif entre 10 et 120 Hz), 
ces smartphones devraient ravir les amoureux de la marque californienne. Ils sont si semblables que nous avons décidé de les regrouper dans ce classement, 
à vous de choisir lequel vous préférez en fonction de la taille (6,7 ou 6,1 pouces).",
                'price' => 1259,
                'brand' => 'Apple',
                'statut' => true
            ],
            [
                'name' => 'Find X3 Neo',
                'description' => "Le Find X3 Neo est un smartphone haut de gamme comme aucun autre. 
Pour le rendre plus abordable que la plupart de ses concurrents, Oppo a eu la judicieuse idée de l'équiper du processeur de l'année dernière, le Snapdragon 865. 
À l'exception de ce « défaut » (il faut relativiser, il est quasiment impossible de constater une différence avec le Snapdragon 888 de 2021), 
l'Oppo Find X3 Neo est un vrai appareil haut de gamme. Ses appareils photo sont géniaux, son autonomie est redoutable, 
son temps de recharge est de seulement 31 minutes… Même son écran OLED 120 Hz fait partie des meilleurs du marché. Petit bonus, il s'agit d'un mobile ultra-fin.",
                'price' => 799,
                'brand' => 'Oppo',
                'statut' => false
            ],
            [
                'name' => 'Find X2 Pro',
                'description' => "Révélation de 2020, l'Oppo Find X2 Pro réussit l'exploit de nous convaincre sur à peu près tous les plans. 
Son design en céramique ou en cuir vegan est sublime, son écran OLED incurvé offre un taux de rafraîchissement de 120 Hz, son processeur Snapdragon 865 
se montre surpuissant et compatible 5G, son triple module caméra est un des meilleurs du marché (il se paye même le luxe d'embarquer un zoom périscopique x5)… 
Difficile de trouver mieux. En bonus, l'Oppo Find X2 Pro dispose d'une technologie de recharge ultra-rapide 65W qui lui permet de se recharger 
intégralement en 36 minutes. Il ne lui manque que la recharge sans-fil pour être parfait. Son successeur, le Find X3 Pro, est le deuxième de notre classement. ",
                'price' => 949,
                'brand' => 'Oppo',
                'statut' => true
            ],
            [
                'name' => '8T',
                'description' => "Avec le 8T, OnePlus revient à sa marque de fabrique. Ce smartphone haut de gamme mise sur le rapport qualité-prix pour se distinguer 
tout en innovant sur quelques aspects comme la recharge ultra-rapide (il ne faut que 41 minutes pour le recharger intégralement grâce à son chargeur de 65 W). 
Si son design manque d'originalité, selon nous, il s'agit d'un des appareils les plus intéressants de ce classement.  ",
                'price' => 599,
                'brand' => 'OnePlus',
                'statut' => true
            ],
            [
                'name' => 'Galaxy S20 FE',
                'description' => "Avec son Galaxy S20 FE, Samsung répliquait à l'iPhone 11. Décliné en six coloris différents, ce smartphone appartient à la catégorie haut de gamme 
malgré son prix relativement abordable. En effet, Samsung a réduit ses coûts de production en abandonnant l'écran incurvé et en optant pour un dos en plastique… 
mais conserve l'écran 120 Hz, la recharge sans-fil et le triple module caméra de son S20 classique. Nous vous recommandons d'opter pour la version 5G de ce smartphone, 
elle est dotée d'un meilleur processeur (Snapdragon 865 au lieu d'Exynos 990) et profite d'une meilleure autonomie.",
                'price' => 700,90,
                'brand' => 'Samsung',
                'statut' => true
            ],
            [
                'name' => 'iPhone 13',
                'description' => "Smartphone de référence d'Apple, l'iPhone 13 est un appareil extrêmement satisfaisant. Très endurant, doué en photo et extrêmement puissant, 
il s'agit d'un des appareils les plus complets de ce classement. Proposé en plusieurs coloris (rose, bleu, noir, blanc et rouge), il se décline en versions 128, 
256 et 512 Go. Sous iOS, il devrait vous offrir plusieurs années de mises à jour logicielles. ",
                'price' => 909,
                'brand' => 'Apple',
                'statut' => true
            ],
            [
                'name' => 'iPhone 13 mini',
                'description' => "L'iPhone 13 mini est le seul petit smartphone de ce classement. Avec son écran de 5,4 pouces, il se destine aux amoureux des appareils compacts, 
ceux qui ont de toutes petites poches et détestent les formats XXL des autres smartphones. Malgré son petit format, il s'agit d'un excellent smartphone avec une puce 
A15 haut de gamme, un double module caméra de qualité et de nombreux composants de haut niveau. Au niveau de l'autonomie, on note aussi une progression par rapport à son prédécesseur.",
                'price' => 809,
                'brand' => 'Apple',
                'statut' => true
            ],
            [
                'name' => 'Mi 11i',
                'description' => "Mieux noté que le Xiaomi Mi 11 (8,77), le Mi 11i est pourtant une version allégée de ce smartphone. Plus fin, doté d'un écran plat et incompatible 
avec la recharge sans-fil, cet appareil se destine aux personnes en quête d'un mobile haut de gamme et de simplicité. Il n'est pas extravagant. 
Sa meilleure note est due à son autonomie largement supérieure, en grande partie grâce à son écran moins énergivore (Full HD+ au lieu de Quad HD+).",
                'price' => 699,
                'brand' => 'Xiaomi',
                'statut' => false
            ]
        ];

        return $data;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data() as $data) {
            $product = new Product();
            $product
                ->setName($data['name'])
                ->setDescription($data['description'])
                ->setPrice($data['price'])
                ->setBrand($data['brand'])
                ->setStatut($data['statut'])
            ;
            $manager->persist($product);
        }
        
        $manager->flush();
    }
}
