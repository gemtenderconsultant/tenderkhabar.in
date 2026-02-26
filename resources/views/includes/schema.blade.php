@php
// Get current URL and path
$currentPath = request()->path();
$segments = explode('/', $currentPath);
$page = end($segments) ?: 'index';
$folder = count($segments) > 1 ? $segments[count($segments) - 2] : '';

$baseUrl = url('/');
$pageUrl = $baseUrl . '/' . ($folder ? $folder . '/' : '') . $page;


$title = trim($__env->yieldContent('title')) ?: 'TenderKhabar - Tender Khabar: Daily Shortlisted Government Tenders Just for You';
$description = trim($__env->yieldContent('meta_description')) ?: 'Stay ahead with Tender Khabar! Get daily updates on government tenders tailored to your specific needs. Sign up now for exclusive access to the best opportunities!';

// Base Schema
$schema = [
    "@context" => "https://schema.org",
    "@graph" => [
        [
            "@type" => "Organization",
            "@id" => "$baseUrl/#organization",
            "name" => "Aarav Tender Consultant Pvt. Ltd",
            "url" => "$baseUrl/",
            "logo" => "$baseUrl/assets/img/Logo Image 1 - Copy.jpg",
            "description" => $description,
            "contactPoint" => [
                "@type" => "ContactPoint",
                "telephone" => "+91-9824895546",
                "contactType" => "Customer Support",
                "areaServed" => "IN",
                "availableLanguage" => ["English", "Hindi"]
            ],
            "sameAs" => [
                "https://www.facebook.com/gemtenderconsultant.in",
                "https://www.instagram.com/gemtenderconsultant.in?igsh=Nm1xd3Q3eG9ld3Jv",
                "https://www.linkedin.com/company/aarav-tender-consultant-private-limited/"
            ]
        ],
        [
            "@type" => "WebSite",
            "@id" => "$baseUrl/#website",
            "url" => "$baseUrl/",
            "name" => "TenderKhabar",
            "publisher" => ["@id" => "$baseUrl/#organization"],
            "potentialAction" => [
                "@type" => "SearchAction",
                "target" => "$baseUrl/?s={search_term_string}",
                "query-input" => "required name=search_term_string"
            ]
        ],
        [
            "@type" => "LocalBusiness",
            "@id" => "$baseUrl/#localbusiness",
            "name" => "TenderKhabar",
            "image" => "$baseUrl/assests/images/Final%20logo%20copy.png",
            "url" => "$baseUrl/",
            "telephone" => "+91-9824895546",
            "priceRange" => "₹₹",
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => "2nd Floor, Jagadish Chamber's Back Side Building, Malgodown Road, Rajkamal Cross Road",
                "addressLocality" => "Mehsana",
                "addressRegion" => "Gujarat",
                "postalCode" => "384002",
                "addressCountry" => "IN"
            ],
            "geo" => [
                "@type" => "GeoCoordinates",
                "latitude" => "23.5890",
                "longitude" => "72.3693"
            ],
            "openingHours" => ["Mo-Sa 09:30-18:30"],
            "sameAs" => [
                "https://www.facebook.com/gemtenderconsultant.in",
                "https://www.instagram.com/gemtenderconsultant.in?igsh=Nm1xd3Q3eG9ld3Jv"
            ]
        ]
    ]
];

// Extra schemas per page
$extraSchema = [];

switch ($page) {
    case 'gem':
        $extraSchema[] = [
            "@type" => "Service",
            "name" => "GEM Services",
            "serviceType" => "GEM Registration",
            "provider" => ["@type" => "Organization", "name" => "TenderKhabar"],
            "areaServed" => "IN",
            "description" => "Get hassle-free seller registration and document validation for GeM portal through TenderKhabar’s professional GEM Services."
        ];
        break;

    case 'bidding':
        $extraSchema[] = [
            "@type" => "Service",
            "name" => "Tender Bidding Services",
            "serviceType" => "Tender Bidding",
            "provider" => ["@type" => "Organization", "name" => "TenderKhabar"],
            "areaServed" => "IN",
            "description" => "Comprehensive support for tender bidding with document preparation, eligibility analysis, and bid submission assistance."
        ];
        break;

    case 'certification':
        $extraSchema[] = [
            "@type" => "Service",
            "name" => "Certification Services",
            "serviceType" => "Product Certification",
            "provider" => ["@type" => "Organization", "name" => "TenderKhabar"],
            "areaServed" => "IN",
            "description" => "Expert help for CE marking and other certifications ensuring compliance and market eligibility for your products."
        ];
        break;
    
     case 'pricing-plans':
            $extraSchema[] = [
            "@type" => "Service",
            "name" => "TenderKhabar Pricing Plan",
            "serviceType" => "TenderKhabar Pricing Plan",
            "provider" => ["@type" => "Organization", "name" => "TenderKhabar"],
            "areaServed" => "IN",
            "description" => "Discover our tailored pricing plans for tender alerts! Choose from Single State, Five States, or All India coverage to suit your needs. Enjoy email support, document assistance, and more. Get started today!"
        ];
        break;

    case 'contact-us':
            $extraSchema[] = [
            "@type" => "Contact",
            "name" => "TenderKhabar Pricing Plan",
            "serviceType" => "TenderKhabar Pricing Plan",
            "provider" => ["@type" => "Organization", "name" => "TenderKhabar"],
            "areaServed" => "IN",
            "description" => "Need assistance? Contact Tender  Khabr today! Reach us via email at sales@gemtenderconsultant.in or call +91 9824 89 5546. Visit us at our Mehsana location for personalized support."
        ];
        break; 
        
    case 'login':
            $extraSchema[] = [
            "@type" => "Login",
            "name" => "TenderKhabar Pricing Plan",
            "serviceType" => "TenderKhabar Pricing Plan",
            "provider" => ["@type" => "Organization", "name" => "TenderKhabar"],
            "areaServed" => "IN",
            "description" => "Discover the latest updates with Login Tender Khabar. Stay informed and never miss out on important news. Click to explore our comprehensive updates today!"
        ];
        break;  
        
    case 'register':
            $extraSchema[] = [
            "@type" => "Register",
            "name" => "TenderKhabar Pricing Plan",
            "serviceType" => "TenderKhabar Pricing Plan",
            "provider" => ["@type" => "Organization", "name" => "TenderKhabar"],
            "areaServed" => "IN",
            "description" => "Join Tender Khabar today! Our simple and secure register process ensures you stay updated with the latest news and offers. Don’t miss out—register now for exclusive access!"
        ];
        break;   
        
    case 'advancesearch':
            $extraSchema[] = [
            "@type" => "Search",
            "name" => "TenderKhabar Pricing Plan",
            "serviceType" => "TenderKhabar Pricing Plan",
            "provider" => ["@type" => "Organization", "name" => "TenderKhabar"],
            "areaServed" => "IN",
            "description" => "Discover the power of our Advance Search tool, designed for seamless data exploration across states and cities in India. Easily filter by department, amount, and more to find exactly what you need. Start your search today!"
        ];
        break;  
        
    case 'privacy-policy':
            $extraSchema[] = [
            "@type" => "Policy",
            "name" => "TenderKhabar Pricing Plan",
            "serviceType" => "TenderKhabar Pricing Plan",
            "provider" => ["@type" => "Organization", "name" => "TenderKhabar"],
            "areaServed" => "IN",
            "description" => "Discover our Privacy Policy at tenderkhabar.in, where your privacy is our priority. Learn how we protect your personal and business information with strict adherence to industry guidelines. Read more to understand your rights and our commitment to data safety."
        ];
        break;      

        
    
}

// Add current page WebPage schema
$schema["@graph"][] = [
    "@type" => "WebPage",
    "@id" => "$pageUrl#webpage",
    "url" => $pageUrl,
    "name" => $title,
    "description" => $description,
    "isPartOf" => ["@id" => "$baseUrl/#website"],
    "about" => ["@id" => "$baseUrl/#organization"]
];

// Merge extras
if (!empty($extraSchema)) {
    $schema["@graph"] = array_merge($schema["@graph"], $extraSchema);
}
@endphp

<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
