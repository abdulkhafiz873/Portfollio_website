<?php
/**
 * Project data shared by index.php (featured) and portfolio.php (all).
 * Replace with a database query later if needed.
 */
$projects = [
    ['id'=>1,'title'=>'Bloom Florist','category'=>'design','tag'=>'Web Design','featured'=>true,
     'image'=>'https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=800&q=70',
     'desc'=>'A soft, editorial storefront design for a boutique florist.','tech'=>['Figma','HTML','CSS'],'link'=>'#'],
    ['id'=>2,'title'=>'TaskFlow Dashboard','category'=>'development','tag'=>'Development','featured'=>true,
     'image'=>'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=70',
     'desc'=>'Project-management dashboard with drag-and-drop boards and charts.','tech'=>['JavaScript','PHP','MySQL'],'link'=>'#'],
    ['id'=>3,'title'=>'Nomad Travel App','category'=>'uiux','tag'=>'UI/UX','featured'=>true,
     'image'=>'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=800&q=70',
     'desc'=>'Mobile app concept for planning trips with friends.','tech'=>['Figma','Prototyping'],'link'=>'#'],
    ['id'=>4,'title'=>'Brew Coffee Co.','category'=>'design','tag'=>'Web Design','featured'=>false,
     'image'=>'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&q=70',
     'desc'=>'Landing page and brand system for a specialty coffee roaster.','tech'=>['Illustrator','HTML','CSS'],'link'=>'#'],
    ['id'=>5,'title'=>'ShopEase E-commerce','category'=>'development','tag'=>'Development','featured'=>false,
     'image'=>'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&q=70',
     'desc'=>'Full e-commerce site with cart, checkout and admin panel.','tech'=>['PHP','MySQL','JavaScript'],'link'=>'#'],
    ['id'=>6,'title'=>'FitTrack','category'=>'uiux','tag'=>'UI/UX','featured'=>false,
     'image'=>'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=800&q=70',
     'desc'=>'Fitness tracking app with progress visualisations.','tech'=>['Figma','User Research'],'link'=>'#'],
];
