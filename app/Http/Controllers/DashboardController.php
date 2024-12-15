<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function test()
    {
        $elements = [
            [
                'symbol' => 'Cu',
                'name' => 'Copper',
                'atomic_number' => 29,
                'atomic_mass' => 63.54,
                'description' => 'Copper is a chemical element with symbol Cu (from Latin: cuprum) and atomic number 29. It is a soft, malleable, and ductile metal with very high thermal and electrical conductivity.',
                'link' => 'https://en.wikipedia.org/wiki/Copper'
            ],
            [
                'symbol' => 'H',
                'name' => 'Hydrogen',
                'atomic_number' => 1,
                'atomic_mass' => 1.008,
                'description' => 'Hydrogen is the lightest element...',
                'link' => 'https://en.wikipedia.org/wiki/Hydrogen',
                'bgImage' => asset('images/research/schutzschild_klasse2.jpg'), // Hintergrundbild hinzufügen
            ],
            [
                'symbol' => 'O',
                'name' => 'Oxygen',
                'atomic_number' => 8,
                'atomic_mass' => 15.999,
                'description' => 'Oxygen is a nonmetal...',
                'link' => 'https://en.wikipedia.org/wiki/Oxygen',
                'bgImage' => asset('images/technologies/artefaktzentrum.png'), // Hintergrundbild hinzufügen
            ],
            // Ein anderes Element: Gold
            [
                'symbol' => 'Au',
                'name' => 'Gold',
                'atomic_number' => 79,
                'atomic_mass' => 196.97,
                'description' => 'Gold is a chemical element with symbol Au (from Latin: aurum) and atomic number 79. It is a dense, soft, malleable, and ductile metal.',
                'link' => 'https://en.wikipedia.org/wiki/Gold'
            ],
            // Nicht-Element Testdaten: Länder
            [
                'symbol' => 'DE',
                'name' => 'Germany',
                'atomic_number' => null, // Keine atomare Nummer
                'atomic_mass' => null,  // Keine atomare Masse
                'description' => 'Germany, officially the Federal Republic of Germany, is a country in Central Europe.',
                'link' => 'https://en.wikipedia.org/wiki/Germany'
            ],
            [
                'symbol' => 'FR',
                'name' => 'France',
                'atomic_number' => null,
                'atomic_mass' => null,
                'description' => 'France, officially the French Republic, is a transcontinental country spanning Western Europe and overseas regions.',
                'link' => 'https://en.wikipedia.org/wiki/France'
            ],
            // Test mit komplett anderen Daten
            [
                'symbol' => '🚀',
                'name' => 'SpaceX',
                'atomic_number' => null,
                'atomic_mass' => null,
                'description' => 'SpaceX designs, develops, and manufactures space launch vehicles, spacecraft, and satellite systems.',
                'link' => 'https://en.wikipedia.org/wiki/SpaceX'
            ],
            [
                'symbol' => '🍎',
                'name' => 'Apple',
                'atomic_number' => null,
                'atomic_mass' => null,
                'description' => 'Apple Inc. is an American multinational technology company headquartered in Cupertino, California.',
                'link' => 'https://en.wikipedia.org/wiki/Apple_Inc.'
            ],
            // Weitere Elemente hinzufügen ...
        ];

        return view('test', ['elements' => $elements, 'test' => 'test']);

    }
}
