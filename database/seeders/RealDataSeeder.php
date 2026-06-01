<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RealDataSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch categories by slug
        $festivals = Category::where('slug', 'festivals')->first() ?? Category::create(['name' => 'Festivals', 'slug' => 'festivals']);
        $sport = Category::where('slug', 'sport')->first() ?? Category::create(['name' => 'Sport', 'slug' => 'sport']);
        $cultuur = Category::where('slug', 'cultuur')->first() ?? Category::create(['name' => 'Cultuur', 'slug' => 'cultuur']);
        $beurzen = Category::where('slug', 'beurzen')->first() ?? Category::create(['name' => 'Beurzen', 'slug' => 'beurzen']);
        $carmeeting = Category::where('slug', 'carmeeting')->first() ?? Category::create(['name' => 'Carmeeting', 'slug' => 'carmeeting']);

        // Data arrays
        $organizationsData = [
            [
                'name' => 'We Are One World / Tomorrowland',
                'subdomain' => 'tomorrowland',
                'events' => [
                    [
                        'title' => 'Tomorrowland 2026',
                        'price_cents' => 12000,
                        'start_date' => '2026-07-17 12:00:00',
                        'category_id' => $festivals->id,
                        'description' => 'Tomorrowland is a large-scale Belgian electronic dance music festival held in Boom, Flanders, Belgium.',
                    ],
                    [
                        'title' => 'Tomorrowland Winter 2027',
                        'price_cents' => 15000,
                        'start_date' => '2027-03-13 09:00:00',
                        'category_id' => $festivals->id,
                        'description' => 'A unique winter festival experience high in the French Alps.',
                    ],
                    [
                        'title' => 'CORE Festival 2026',
                        'price_cents' => 6500,
                        'start_date' => '2026-06-27 13:00:00',
                        'category_id' => $festivals->id,
                        'description' => 'A boutique festival in the beautiful capital of Belgium.',
                    ]
                ]
            ],
            [
                'name' => 'Live Nation Belgium',
                'subdomain' => 'livenation',
                'events' => [
                    [
                        'title' => 'Rock Werchter 2026',
                        'price_cents' => 11000,
                        'start_date' => '2026-07-02 11:00:00',
                        'category_id' => $festivals->id,
                        'description' => 'Rock Werchter is an annual music festival held in the village of Werchter, Belgium.',
                    ],
                    [
                        'title' => 'TW Classic 2026',
                        'price_cents' => 9500,
                        'start_date' => '2026-06-20 12:00:00',
                        'category_id' => $festivals->id,
                        'description' => 'A classic one-day festival featuring legendary rock and pop headliners.',
                    ]
                ]
            ],
            [
                'name' => 'KBVB (Belgische Voetbalbond)',
                'subdomain' => 'kbvb',
                'events' => [
                    [
                        'title' => 'Rode Duivels Kwalificatiewedstrijd',
                        'price_cents' => 4500,
                        'start_date' => '2026-10-12 20:45:00',
                        'category_id' => $sport->id,
                        'description' => 'Come support the Red Devils at the King Baudouin Stadium in Brussels!',
                    ],
                    [
                        'title' => 'Finale Beker van België 2027',
                        'price_cents' => 3500,
                        'start_date' => '2027-05-15 18:00:00',
                        'category_id' => $sport->id,
                        'description' => 'The ultimate clash for the Belgian Cup championship.',
                    ]
                ]
            ],
            [
                'name' => 'Flanders Classics',
                'subdomain' => 'flandersclassics',
                'events' => [
                    [
                        'title' => 'Ronde van Vlaanderen 2027',
                        'price_cents' => 2500,
                        'start_date' => '2027-04-04 10:00:00',
                        'category_id' => $sport->id,
                        'description' => 'De Ronde van Vlaanderen is the most beautiful cycling classic of Flanders.',
                    ],
                    [
                        'title' => 'Omloop Het Nieuwsblad 2027',
                        'price_cents' => 1500,
                        'start_date' => '2027-02-27 09:00:00',
                        'category_id' => $sport->id,
                        'description' => 'The opening weekend of the Belgian cycling season.',
                    ]
                ]
            ],
            [
                'name' => 'Kunstencentrum VIERNULVIER (Gent)',
                'subdomain' => 'viernulvier',
                'events' => [
                    [
                        'title' => 'Theatervoorstelling VIERNULVIER',
                        'price_cents' => 2000,
                        'start_date' => '2026-11-05 20:00:00',
                        'category_id' => $cultuur->id,
                        'description' => 'Experience contemporary theatre and performing arts in the heart of Ghent.',
                    ],
                    [
                        'title' => 'Comedy Night Gent',
                        'price_cents' => 1800,
                        'start_date' => '2026-09-18 20:30:00',
                        'category_id' => $cultuur->id,
                        'description' => 'A stellar line-up of Flemish and international stand-up comedians.',
                    ]
                ]
            ],
            [
                'name' => 'Kinepolis Group',
                'subdomain' => 'kinepolis',
                'events' => [
                    [
                        'title' => 'Ladies at the Movies',
                        'price_cents' => 1700,
                        'start_date' => '2026-06-11 19:30:00',
                        'category_id' => $cultuur->id,
                        'description' => 'A special movie night for ladies with snacks, goodie bags, and prime preview screenings.',
                    ],
                    [
                        'title' => 'Avant-première Blockbuster',
                        'price_cents' => 1500,
                        'start_date' => '2026-08-25 20:00:00',
                        'category_id' => $cultuur->id,
                        'description' => 'Be the first to watch the highly anticipated blockbuster movie.',
                    ]
                ]
            ],
            [
                'name' => 'FACTS Convention / Easyfairs',
                'subdomain' => 'facts',
                'events' => [
                    [
                        'title' => 'FACTS Spring 2027',
                        'price_cents' => 2800,
                        'start_date' => '2027-04-03 09:00:00',
                        'category_id' => $beurzen->id,
                        'description' => 'The Belgian Comic Con at Flanders Expo. Meet actors, cosplayers, artists, and enjoy merchandise.',
                    ]
                ]
            ],
            [
                'name' => 'FEBIAC',
                'subdomain' => 'febiac',
                'events' => [
                    [
                        'title' => 'Het Autosalon 2027 (Brussels Motor Show)',
                        'price_cents' => 1500,
                        'start_date' => '2027-01-15 10:00:00',
                        'category_id' => $beurzen->id,
                        'description' => 'The biggest mobility and automotive showcase event in Belgium.',
                    ]
                ]
            ],
            [
                'name' => 'Kortrijk Xpo / Boek.be',
                'subdomain' => 'boektopia',
                'events' => [
                    [
                        'title' => 'Boektopia 2026',
                        'price_cents' => 1200,
                        'start_date' => '2026-10-31 10:00:00',
                        'category_id' => $beurzen->id,
                        'description' => 'The modern literatures & book fair experience at Kortrijk Xpo.',
                    ],
                    [
                        'title' => 'Lokaal Boekenfestijn',
                        'price_cents' => 500,
                        'start_date' => '2026-12-05 10:00:00',
                        'category_id' => $beurzen->id,
                        'description' => 'Local cozy book fair with local authors and second-hand sales.',
                    ]
                ]
            ],
            [
                'name' => 'Conceptum Exhibitions',
                'subdomain' => 'conceptum',
                'events' => [
                    [
                        'title' => 'Creativa 2026',
                        'price_cents' => 1000,
                        'start_date' => '2026-10-15 10:00:00',
                        'category_id' => $beurzen->id,
                        'description' => 'The largest creative hobbies, DIY and sewing fair in Belgium.',
                    ],
                    [
                        'title' => 'Tuinbeurs 2027',
                        'price_cents' => 800,
                        'start_date' => '2027-03-20 10:00:00',
                        'category_id' => $beurzen->id,
                        'description' => 'Spring exhibition for garden layout, plants, and exterior designs.',
                    ]
                ]
            ],
            [
                'name' => 'GR8 Magazine / Zoute Grand Prix',
                'subdomain' => 'zoutegrandprix',
                'events' => [
                    [
                        'title' => 'GR8 International Car Show',
                        'price_cents' => 2200,
                        'start_date' => '2026-10-10 10:00:00',
                        'category_id' => $carmeeting->id,
                        'description' => 'Premium indoor tuning and styling car show at Kortrijk Xpo.',
                    ],
                    [
                        'title' => 'Zoute Grand Prix 2026',
                        'price_cents' => 4000,
                        'start_date' => '2026-10-08 09:00:00',
                        'category_id' => $carmeeting->id,
                        'description' => 'Prestigious vintage and luxury automobile event at Knokke-Heist.',
                    ]
                ]
            ],
        ];

        foreach ($organizationsData as $orgInfo) {
            $org = Organization::updateOrCreate(
                ['subdomain' => $orgInfo['subdomain']],
                ['name' => $orgInfo['name']]
            );

            foreach ($orgInfo['events'] as $eventInfo) {
                $event = Event::updateOrCreate(
                    ['slug' => Str::slug($eventInfo['title'])],
                    [
                        'organization_id' => $org->id,
                        'category_id' => $eventInfo['category_id'],
                        'uuid' => (string) Str::uuid(),
                        'title' => $eventInfo['title'],
                        'description' => $eventInfo['description'],
                        'price_cents' => $eventInfo['price_cents'],
                        'start_date' => $eventInfo['start_date'],
                        'end_date' => date('Y-m-d H:i:s', strtotime($eventInfo['start_date'] . ' + 6 hours')),
                        'is_published' => true,
                        'published_at' => now(),
                    ]
                );

                // Clear existing ticket types first to avoid duplicates
                \App\Models\TicketType::where('event_id', $event->id)->delete();

                // Seed highly realistic TicketTypes based on the organization's subdomain
                if ($orgInfo['subdomain'] === 'tomorrowland') {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Dagticket',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 15000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Weekendpas (Full Madness)',
                        'price_cents' => $event->price_cents * 2.5,
                        'available_quantity' => 20000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Camping (DreamVille) Upgrade',
                        'price_cents' => 8000,
                        'available_quantity' => 10000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'VIP/Comfort Ticket',
                        'price_cents' => $event->price_cents * 3.5,
                        'available_quantity' => 2000,
                        'is_published' => true,
                    ]);
                } elseif ($orgInfo['subdomain'] === 'livenation') {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Golden Circle (vooraan staan)',
                        'price_cents' => $event->price_cents * 1.6,
                        'available_quantity' => 2500,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Reguliere staanplaatsen',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 12000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Genummerde zitplaatsen',
                        'price_cents' => $event->price_cents * 1.15,
                        'available_quantity' => 5000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Rolstoelplaatsen',
                        'price_cents' => $event->price_cents * 0.85,
                        'available_quantity' => 100,
                        'is_published' => true,
                    ]);
                } elseif ($orgInfo['subdomain'] === 'kbvb') {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Regulier (Vak/Rij/Stoel)',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 35000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Kindertarief',
                        'price_cents' => $event->price_cents * 0.45,
                        'available_quantity' => 5000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Familieticket (groepsverband)',
                        'price_cents' => $event->price_cents * 0.75,
                        'available_quantity' => 5000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Business Seat',
                        'price_cents' => 15000,
                        'available_quantity' => 1200,
                        'is_published' => true,
                    ]);
                } elseif ($orgInfo['subdomain'] === 'flandersclassics') {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'VIP-dorp langs het parcours',
                        'price_cents' => 25000,
                        'available_quantity' => 500,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Shuttledienst (Busticket)',
                        'price_cents' => 1500,
                        'available_quantity' => 2000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Toegang tot de aankomstzone',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 5000,
                        'is_published' => true,
                    ]);
                } elseif ($orgInfo['subdomain'] === 'viernulvier') {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Standaardtarief',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 300,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Studententarief (-26 jaar)',
                        'price_cents' => $event->price_cents * 0.6,
                        'available_quantity' => 100,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Reductietarief (werkzoekenden)',
                        'price_cents' => $event->price_cents * 0.5,
                        'available_quantity' => 50,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Groepsreservering (vanaf 10 pers.)',
                        'price_cents' => $event->price_cents * 0.75,
                        'available_quantity' => 150,
                        'is_published' => true,
                    ]);
                } elseif ($orgInfo['subdomain'] === 'kinepolis') {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Cosy Seats (luxe zetels)',
                        'price_cents' => $event->price_cents + 400,
                        'available_quantity' => 80,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Standaard Film Ticket',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 450,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Cosy Seat + Popcorn & Drank Voucher',
                        'price_cents' => $event->price_cents + 1000,
                        'available_quantity' => 150,
                        'is_published' => true,
                    ]);
                } elseif ($orgInfo['subdomain'] === 'facts') {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Early Bird ticket',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 3000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Fast Lane Access pass',
                        'price_cents' => $event->price_cents * 2.0,
                        'available_quantity' => 1000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Fotoshoot & Handtekening Add-on',
                        'price_cents' => 7500,
                        'available_quantity' => 500,
                        'is_published' => true,
                    ]);
                } elseif ($orgInfo['subdomain'] === 'febiac') {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'B2B Professional Ticket (Bedrijven)',
                        'price_cents' => 4500,
                        'available_quantity' => 15000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'B2C Regulier Ticket (Particulieren)',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 50000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Tijdslot Ticket (Inkom 10:00 - 13:00)',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 10000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Tijdslot Ticket (Inkom 13:00 - 17:00)',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 10000,
                        'is_published' => true,
                    ]);
                } elseif ($orgInfo['subdomain'] === 'boektopia') {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Combiticket (Inkom + Boekenbon van €10)',
                        'price_cents' => 1800,
                        'available_quantity' => 5000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Signeersessie Tijdslot (Gratis Reservering)',
                        'price_cents' => 0,
                        'available_quantity' => 150,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Scholentarief (Klassen in groepsverband)',
                        'price_cents' => 500,
                        'available_quantity' => 3000,
                        'is_published' => true,
                    ]);
                } elseif ($orgInfo['subdomain'] === 'conceptum') {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Standaard Ingangsticket',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 4000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Inkom + Workshop Add-on (Max 15 personen per sessie)',
                        'price_cents' => 3500,
                        'available_quantity' => 150,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Meerdagenpas (Passe-partout weekend)',
                        'price_cents' => 2500,
                        'available_quantity' => 1000,
                        'is_published' => true,
                    ]);
                } elseif ($orgInfo['subdomain'] === 'zoutegrandprix') {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Bezoeker ticket (Alleen kijken)',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 15000,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Deelnemer ticket (Auto + 1 Bestuurder)',
                        'price_cents' => 12000,
                        'available_quantity' => 350,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'VIP/Paddock Pas (Exclusieve toegang)',
                        'price_cents' => 25000,
                        'available_quantity' => 1200,
                        'is_published' => true,
                    ]);
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Rally-inschrijving (Team incl. catering & roadbook)',
                        'price_cents' => 45000,
                        'available_quantity' => 150,
                        'is_published' => true,
                    ]);
                } else {
                    \App\Models\TicketType::create([
                        'event_id' => $event->id,
                        'name' => 'Standaard ticket',
                        'price_cents' => $event->price_cents,
                        'available_quantity' => 500,
                        'is_published' => true,
                    ]);
                }
            }
        }
    }
}
