<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $number = isset($data['number']) ? (int)$data['number'] : 1;
    $rarity = isset($data['rarity']) ? $data['rarity'] : '';
    $type = isset($data['type']) ? $data['type'] : '';

    // Fetch all equipment from the API
    $apiUrl = 'https://www.dnd5eapi.co/api/equipment';
    $response = file_get_contents($apiUrl);
    $itemData = json_decode($response, true);

    $filteredItems = $itemData['results'];

    // Filter items by type and rarity if specified
    if ($type || $rarity) {
        $filteredItems = array_filter($filteredItems, function($item) use ($type, $rarity) {
            $itemDetails = json_decode(file_get_contents("https://www.dnd5eapi.co" . $item['url']), true);

            $matchesType = !$type || (isset($itemDetails['equipment_category']) && $itemDetails['equipment_category']['index'] === $type);
            $matchesRarity = !$rarity || (isset($itemDetails['rarity']) && $itemDetails['rarity']['name'] === $rarity);

            return $matchesType && $matchesRarity;
        });
    }

    $items = [];

    // Select random items from the filtered list
    for ($i = 0; $i < $number && count($filteredItems) > 0; $i++) {
        $randomItem = $filteredItems[array_rand($filteredItems)];
        $itemDetails = json_decode(file_get_contents("https://www.dnd5eapi.co" . $randomItem['url']), true);

        $items[] = [
            'name' => $itemDetails['name'],
            'rarity' => $itemDetails['rarity']['name'] ?? 'Unknown',
            'properties' => isset($itemDetails['properties']) ? implode(', ', array_column($itemDetails['properties'], 'name')) : 'No properties',
            'price' => isset($itemDetails['cost']) ? $itemDetails['cost']['quantity'] . ' ' . $itemDetails['cost']['unit'] : 'No price',
            'description' => isset($itemDetails['desc']) ? implode(' ', $itemDetails['desc']) : 'No description available'
        ];
    }

    echo json_encode($items);
}
?>
