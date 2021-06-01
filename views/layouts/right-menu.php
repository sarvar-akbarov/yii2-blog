<?=\yiister\gentelella\widgets\Menu::widget(
    [
        "items" => [
            ["label" => "Bosh Sahifa", "url" => "/", "icon" => "home"],
            [
                "label" => "Test",
                "url" => "#",
                "icon" => "bar-chart",
                "items" => [
                    [
                        "label" => Yii::t('app', 'Start exam'),
                        "url" => "/exam",
                    ],
                    [
                        "label" => Yii::t('app','Results'),
                        "url" => "/results",
                    ],
                ],
            ],
            ["label" => "Yangiliklar", "url" => ["/articles/news"], "icon" => "newspaper-o"],
            [
                "label" => "Taqdimotlar",
                "url" => ["/presentation/list"],
                "icon" => "file-image-o"
            ],
            [
                "label" => "Foydalanuvchilar",
                "url" => ["/users"],
                "icon" => "users"
            ],

            ["label" => "Kategoriyalar", "url" => ["/blog-category"], "icon" => "tasks"],
            [
                "label" => "Sozlamalar",
                "url" => "#",
                "icon" => "cogs",
                "items" => [
                    [
                        "label" => 'Biz haqimizda',
                        "url" => ["/about-company"],
                        "badgeOptions" => ["class" => "label-success"],
                    ],
                    [
                        "label" => 'Til',
                        "url" => ["/language"],
                        "badgeOptions" => ["class" => "label-success"],
                    ],
                    
                ],
            ]

        ],
    ]
)
?>