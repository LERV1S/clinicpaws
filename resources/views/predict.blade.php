<form action="/predict" method="POST">
    @csrf
    <label for="AnimalName">Nombre del Animal:</label>
    <input type="text" name="AnimalName" id="AnimalName" required><br>

    <label for="symptoms1">Síntoma 1:</label>
    <input type="text" name="symptoms1" id="symptoms1" required><br>

    <label for="symptoms2">Síntoma 2:</label>
    <input type="text" name="symptoms2" id="symptoms2" required><br>

    <label for="symptoms3">Síntoma 3:</label>
    <input type="text" name="symptoms3" id="symptoms3" required><br>

    <label for="symptoms4">Síntoma 4:</label>
    <input type="text" name="symptoms4" id="symptoms4" required><br>

    <label for="symptoms5">Síntoma 5:</label>
    <input type="text" name="symptoms5" id="symptoms5" required><br>

    <button type="submit">Predecir</button>
</form>
