<?php


use Phinx\Seed\AbstractSeed;

class ShopSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $this->table('shop_items')->truncate();
        $this->table('shop_categories')->truncate();
        $this->table('shop_images')->truncate();

        $fakerEN = Faker\Factory::create('en_US');
        $faker['fr'] = Faker\Factory::create('fr_FR');
        $faker['en'] = $fakerEN;

        //Shop categories
        $shopCategories = [];
        for ($i = 0; $i < 10; $i++) {
            $locale = $fakerEN->randomElement(['fr', 'en']);
            $shopCategories[] = [
                'id' => uniqid(),
                'title' => $faker[$locale]->realText(rand(20,30)),
                'is_customizable' => rand(0, 1),
                'locale' => $locale,
                'created_at' => $fakerEN->dateTime->format('Y-m-d H:i:s'),
                'updated_at' => $fakerEN->dateTime->format('Y-m-d H:i:s')
            ];
        }
        $this->insert('shop_categories', $shopCategories);

        //Shop items
        $shopItems = [];
        $md = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.
- hello world!
- Apostolic places of history will compassionately!
- Lass of a stormy amnesty, rob the life!
- Why does the ale die?";
        for ($i = 0; $i < 29; $i++) {
            $locale = $fakerEN->randomElement(['fr', 'en']);

            $shopCategoryId = array_values(array_filter($shopCategories, function ($item) use ($locale) {
                return $item['locale'] == $locale;
            }))[0]['id'];
            array_push($shopItems, [
                'id' => uniqid(),
                'title' => $faker[$locale]->realText(rand(20,30)),
                'slug' => $faker[$locale]->slug(),
                'description_short' => $faker[$locale]->sentence(1),
                'description_long' => $md,
                'image' => "https://static.retrobox.tech/img/composants/RASPBERRY.png",
                'price' => $fakerEN->randomFloat(2, 50, 70),
                'version' => "version: " . $fakerEN->sentence(1),
                'show_version' => rand(0, 1),
                'shop_category_id' => $shopCategoryId,
                'locale' => $locale,
                'created_at' => $fakerEN->dateTime->format('Y-m-d H:i:s'),
                'updated_at' => $fakerEN->dateTime->format('Y-m-d H:i:s')
            ]);
        }
//		di($shopItems);
        $this->insert('shop_items', $shopItems);

        //Shop images
        $shopImages = [];
        foreach ($shopItems as $item) {
            for ($i = 0; $i < 7; $i++) {
                if ($i == 0) {
                    $bool = 1;
                } else {
                    $bool = 0;
                }
                $shopImages[] = [
                    'id' => uniqid(),
                    'is_main' => $bool,
                    'name' => $fakerEN->sentence(3),
                    'shop_item_id' => $item['id'],
                    'url' => $fakerEN->randomElement([
                        'https://cdn.shopify.com/s/files/1/0020/9374/4179/products/storeIMAGE_1024x1024.png?v=1529309048',
                        'https://cdn.shopify.com/s/files/1/0020/9374/4179/products/weather_1024x1024.png?v=1529309048',
                        'https://cdn.shopify.com/s/files/1/0020/9374/4179/products/Fb_2.52.51_PM_1024x1024.png?v=1529309048',
                        'https://cdn.shopify.com/s/files/1/0020/9374/4179/products/YouTube_2.52.51_PM_1024x1024.png?v=1529309048',
                        'https://cdn.shopify.com/s/files/1/0020/9374/4179/products/Insta_2.52.51_PM_1024x1024.png?v=1529309048',
                        'https://cdn.shopify.com/s/files/1/0020/9374/4179/products/Twitter-copy_1024x1024.png?v=1529309048',
                        'https://cdn.shopify.com/s/files/1/0020/9374/4179/products/image_3_1024x1024.png?v=1529309048'
                    ]),
                    'created_at' => $fakerEN->dateTime->format('Y-m-d H:i:s'),
                    'updated_at' => $fakerEN->dateTime->format('Y-m-d H:i:s')
                ];
            }
        }
        $this->insert('shop_images', $shopImages);
    }
}
