<div class="insidecontainer">
    <form id="equipment-form" action="{{ route('equipments.store')}}" method="POST">
        @csrf
        <input type="hidden" name="from_partial" value="user-create-equipment">

        <br>
        <div class="ICtitulo">
            <h5>{{__('Detalhes da Avaria:')}}</h5>
        </div>
        <br>
        <div class="card1">
            <h4>{{__('Tipo de Equipamento:')}}</h4>
            <br>
            <input type="text" id="type" name="type" value="{{ old('type', $other_type ?? '') }}" readonly>
            @error('type')
            <span class="erro">{{ $message }}</span>
            @enderror
        </div>
        <div class="card1" id="newTypeContainer">
            <h4>{{__('Novo Tipo de Equipamento:')}}</h4>
            <input type="text" id="new_type" name="new_type" value="{{ old('new_type', '') }}">
            <br>
        </div>

        <div class="card1">
            <h4>{{__('Fabricante:')}}</h4>
            <br>
            <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer', '') }}" required>
            @error('manufacturer')
            <span class="erro">{{ $message }}</span>
            @enderror </div>


        <div class="card1">
            <h4>{{__('Modelo:')}}</h4>
            <br>
            <input type="text" id="model" name="model" value="{{ old('model', '') }}" required>
            @error('model')
            <span class="erro">{{ $message }}</span>
            @enderror
        </div>


        <div class="card1">
            <h4>{{__('Serial Number:')}}</h4>
            <br>
            <input type="text" id="serial_number" name="serial_number" value="{{ old('serial_number', '') }}" required>
            @error('serial_number')
            <span class="erro">{{ $message }}</span>
            @enderror
        </div>

        <div class="card1">
            <h4>{{__('Sala:')}}</h4>
            <br>
            <input type="text" id="room" name="room" value="{{ old('room', '') }}">
            @error('room')
            <span class="erro">{{ $message }}</span>
            @enderror
        </div>

        <div class="botoes" style="margin-left: 10px">
            <br>
            <button type="submit" id="botao_p" >{{ __('Gravar') }}</button>
            <a href="{{ route('tickets.create') }}">
                <input type="button" id="botao2_p" value="{{ __('Cancelar') }}">
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Captura o campo de tipo e o campo novo tipo
        const typeInput = document.getElementById('type');
        const newTypeContainer = document.getElementById('newTypeContainer');

        // Função para verificar o valor do tipo selecionado
        function checkType() {
            // Verifica se o valor do tipo é 'OTHER'
            if (typeInput.value !== 'OTHER') { // Altere 'OTHER' para o valor que deseja verificar
                newTypeContainer.style.display = 'none'; // Oculta o campo de novo tipo
            } else {
                newTypeContainer.style.display = 'block'; // Exibe o campo de novo tipo
            }
        }

        // Inicializa a verificação ao carregar a página
        checkType();

        // Adiciona um listener para mudanças no campo de tipo
        typeInput.addEventListener('input', checkType);
    });
</script>
