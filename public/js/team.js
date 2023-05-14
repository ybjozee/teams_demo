const form = document.getElementById('form');
const addPlayerButtonDiv = document.getElementById('addPlayerButtonDiv')
let playerCount = document.getElementsByClassName('playerInput').length;

const getPlayerFieldJSX = (index) => `
        <div class="col-5">
            <input type="text" class="form-control" placeholder="Name" name="players[${index}][name]" required>
            <div class="invalid-feedback">
                Please provide the player's name.
            </div>
        </div>
        <div class="col-5">
            <input type="text" class="form-control" placeholder="Surname" name="players[${index}][surname]" required>
            <div class="invalid-feedback">
                Please provide the player's surname.
            </div>
        </div>
        <div class="col">
            <div class="input-group">
                <button class="btn" type="button" onclick="handleAddPlayerButtonClick()">
                    <i class="bi bi-patch-plus text-success" style="font-size: 1.3rem"></i>
                </button>
                <button class="btn" type="button" onclick="deletePlayerField(${index})">
                    <i class="bi bi-trash3 text-danger" style="font-size: 1.3rem"></i>
                </button>
            </div>
        </div>
`;

const handleAddPlayerButtonClick = () => {
    addPlayerButtonDiv.style.display = 'none';
    const div = document.createElement('div');
    div.setAttribute('class', 'row g-3 mb-3 playerInput');
    div.setAttribute('id', `player_${playerCount}`)
    div.innerHTML = getPlayerFieldJSX(playerCount);
    const lastPlayerInput = document.getElementById(`player_${playerCount-1}`);
    const lastChild = lastPlayerInput ?? document.getElementById('addPlayerButtonDiv');
    lastChild.after(div);
    playerCount++;
}

const deletePlayerField = (index) => {
    const player = document.getElementById(`player_${index}`);
    player.parentNode.removeChild(player);
    playerCount--;
    if (playerCount === 0) {
        addPlayerButtonDiv.style.display = 'block';
    }
}