<form id="item-form">
    <label for="number">Number of items:</label>
    <input type="number" id="number" name="number" required>

    <label for="rarity">Rarity:</label>
    <select id="rarity" name="rarity">
        <option value="">Any</option>
        <option value="common">Common</option>
        <option value="uncommon">Uncommon</option>
        <option value="rare">Rare</option>
        <option value="very rare">Very Rare</option>
        <option value="legendary">Legendary</option>
    </select>

    <label for="type">Type:</label>
    <select id="type" name="type">
        <option value="">Any</option>
        <option value="weapon">Weapon</option>
        <option value="armor">Armor</option>
        <option value="potion">Potion</option>
        <option value="ring">Ring</option>
        <option value="wondrous item">Wondrous Item</option>
    </select>

    <button type="submit">Generate</button>
</form>

<div id="loot-results"></div>

<script>
    document.getElementById('item-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const number = document.getElementById('number').value;
        const rarity = document.getElementById('rarity').value;
        const type = document.getElementById('type').value;

        fetch('generate_items.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ number, rarity, type })
        })
        .then(response => response.json())
        .then(data => {
            const lootResults = document.getElementById('loot-results');
            lootResults.innerHTML = '';
            data.forEach(item => {
                const lootItem = document.createElement('div');
                lootItem.className = 'loot-item';

                const itemName = document.createElement('h3');
                itemName.className = 'loot-name';
                itemName.textContent = item.name;
                itemName.addEventListener('click', () => {
                    const description = itemName.nextElementSibling;
                    description.style.display = description.style.display === 'none' ? 'block' : 'none';
                });

                const itemDescription = document.createElement('div');
                itemDescription.className = 'loot-description';

                const itemDescriptionText = document.createElement('p');
                itemDescriptionText.textContent = `${item.rarity}, ${item.properties}`;
                const fullDescription = document.createElement('p');
                fullDescription.textContent = item.description;

                itemDescription.appendChild(itemDescriptionText);
                itemDescription.appendChild(fullDescription);
                lootItem.appendChild(itemName);
                lootItem.appendChild(itemDescription);

                const itemPrice = document.createElement('h2');
                itemPrice.className = 'loot-price';
                itemPrice.textContent = item.price;

                lootItem.appendChild(itemPrice);

                lootResults.appendChild(lootItem);
            });
        })
        .catch(error => console.error('Error:', error));
    });
</script>