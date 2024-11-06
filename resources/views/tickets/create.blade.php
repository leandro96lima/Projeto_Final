<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/ticket.css">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">

    <title>QuickFix</title>
</head>

<body>

@include('layouts.quick-fix-nav')

<header>
    <main>
        <h1>{{__('Registar Ticket')}}</h1>
    </main>
</header>

<div id="formContent" class="container_p">
    <div class="insidecontainer_P">

        @if ($errors->has('ticket'))
            <div class="erro">{{ $errors->first('ticket') }}</div>
        @endif

        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf
        <br>
            <div class="card1">
                <h4>{{__('Tipo de Equipamento:')}}</h4>
                <br>
                @if(isset($other_type))
                    <input type="text" id="type" name="type" value="{{ $other_type }}" readonly>
                @else
                <select id="type" name="type" required>
                    <option value="">Selecione um Tipo de Equipamento</option>
                    @foreach($equipmentTypes as $equipmentType)
                        <option value="{{ $equipmentType->value }}" {{ old('type') === $equipmentType->value ? 'selected' : '' }}>{{ $equipmentType->name }}</option>
                    @endforeach
                    <option value="OTHER" {{ old('type') === 'OTHER' ? 'selected' : '' }}>OTHER</option>
                </select>
                @endif
                @error('type')
                <span class="erro">{{ $message }}</span>
                @enderror
            </div>

            <div class="card1">
                <h4>{{__('Serial Number:')}}</h4>
                <br>
                @if(isset($other_serial_number))
                    <input type="text" id="serial_number" name="serial_number" value="{{ $other_serial_number }}" readonly>
                @else
                    <select id="serial_number" name="serial_number" required>
                        <option value="">Selecione um Número de Série</option>
                    </select>
                @endif
                @error('serial_number') <span class="erro">{{ $message }}</span> @enderror
            </div>

            <div class="card1">
                <h4>{{__('Sala:')}}</h4>
                <br>
                @if(isset($other_room))
                    <input type="text" id="room" name="room" value="{{ $other_room }}" readonly>
                @else
                <input type="text" id="room" name="room"
                       value="{{ old('room') }}" placeholder="Número da Sala">
                @endif
                @error('room')
                <div class="erro">{{ $message }}</div>
                @enderror
            </div>

            <div class="card1">
                <h4>{{__('Avaria')}}</h4>
                <br>
                <input type="text" id="title" name="title"
                       value="{{ old('title') }}" placeholder="Descrição do Problema" required>
                @error('title')
                <div class="erro">{{ $message }}</div>
                @enderror
            </div>

            <div class="card2">
                <h4>{{__('Detalhes da Avaria')}}</h4>
                <br>
                <textarea id="description" name="description"
                          placeholder="Coloque os Detalhes" required  style="height:160px;">{{ old('description') }}</textarea>
                @error('description')
                <div class="erro">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <br>
                <input type="submit" id="botao_gravar" value="{{__('Gravar')}}">
            </div>
        </form>
    </div>
</div>

<div class="container_p" id="partialContent" style="display: none;">
    @include('tickets.partials.user-create-equipment')
</div>


<script>
    const equipmentData = @json($equipments);
    const fromPartial = @json(session('from_partial'));

    // Função: Alternar Exibição de Conteúdo
    const togglePartialDisplay = () => {
        const selectedType = document.getElementById('type').value.toUpperCase();
        const selectedSerial = document.getElementById('serial_number').value;
        const shouldShowPartial = selectedType === 'OTHER' || selectedSerial === 'NEW' || fromPartial === 'user-create-equipment';

        document.getElementById('formContent').style.display = shouldShowPartial ? 'none' : 'block';
        document.getElementById('partialContent').style.display = shouldShowPartial ? 'block' : 'none';

        if (shouldShowPartial) {
            const typeInput = document.querySelector('#partialContent input[name="type"]');
            if (!typeInput.value) typeInput.value = selectedType;
        }
    };

    // Função: Atualizar Números de Série
    function updateSerialNumbers() {
        const typeSelect = document.getElementById('type');
        const serialNumberSelect = document.getElementById('serial_number');
        const selectedType = typeSelect.value;

        // Limpa o dropdown de números de série
        serialNumberSelect.innerHTML = '<option value="">Selecione um Número de Série</option>';

        // Filtra os equipamentos com base no tipo selecionado e adiciona ao dropdown
        const filteredEquipments = equipmentData.filter(equipment => (equipment.type === selectedType) && equipment.is_approved);
        if (filteredEquipments.length > 0) {
            filteredEquipments.forEach(equipment => {
                const option = document.createElement('option');
                option.value = equipment.serial_number;
                option.textContent = equipment.serial_number;
                serialNumberSelect.appendChild(option);
            });
        } else {
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'Nenhum número de série disponível';
            serialNumberSelect.appendChild(option);
        }

        const newOption = document.createElement('option');
        newOption.value = 'NEW';
        newOption.textContent = 'Novo';
        serialNumberSelect.appendChild(newOption);
    }


    // Função: Atualizar Sala com Base no Número de Série
    const updateRoomBasedOnSerial = () => {
        const serialNumberSelect = document.getElementById('serial_number');
        const roomInput = document.getElementById('room');
        const selectedEquipment = equipmentData.find(e => e.serial_number === serialNumberSelect.value);

        roomInput.value = selectedEquipment?.room || '';
        roomInput.readOnly = !!selectedEquipment?.room;
    };

    // Adiciona eventos de mudança
    document.getElementById('type').addEventListener('change', () => {
        updateSerialNumbers();
        togglePartialDisplay();
    });

    document.getElementById('serial_number').addEventListener('change', () => {
        updateRoomBasedOnSerial();
        togglePartialDisplay();
    });

    // Chama as funções ao carregar a página
    document.addEventListener('DOMContentLoaded', () => {
        togglePartialDisplay();
        updateSerialNumbers();
    });
</script>

<script>

    document.getElementById('open_btn').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const dropdowns = document.querySelectorAll('.dropdown');
        const arrowIcon = document.getElementById('arrow-icon');

        // Toggle sidebar visibility
        sidebar.classList.toggle('open-sidebar');

        // Close all dropdowns
        dropdowns.forEach(dropdown => {
            dropdown.style.display = 'none';
        });

        // Reset arrow icon if sidebar is closing
        if (!sidebar.classList.contains('open-sidebar')) {
            arrowIcon.style.transform = 'rotate(0deg)';
        }
    });

    // --------------------------------------------

    const sideItems = document.querySelectorAll('.side-item');

    sideItems.forEach(item => {
        item.addEventListener('click', () => {
            // Remove 'active' class from all side items
            sideItems.forEach(sideItem => {
                sideItem.classList.remove('active');
            });

            // Add 'active' class to the clicked item
            item.classList.add('active');
        });
    });

    // ----------------------------------------------

    document.getElementById('menu-toggle').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action of the link
        const dropdown = this.nextElementSibling.querySelector('.dropdown');
        const arrowIcon = document.getElementById('arrow-icon');

        // Toggle dropdown visibility
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';

        // Rotate the arrow icon
        if (dropdown.style.display === 'block') {
            arrowIcon.style.transform = 'rotate(180deg)';
        } else {
            arrowIcon.style.transform = 'rotate(0deg)';
        }
    });


    document.addEventListener('DOMContentLoaded', () => {
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('#side_items a');

        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.6 // Adjusts when the section is considered in view
        };

        const observerCallback = (entries) => {
            entries.forEach(entry => {
                const id = entry.target.getAttribute('id');
                const navLink = document.querySelector(`#side_items a[href="#${id}"]`);

                if (entry.isIntersecting) {
                    navLink.classList.add('active');
                } else {
                    navLink.classList.remove('active');
                }
            });
        };

        const observer = new IntersectionObserver(observerCallback, observerOptions);

        sections.forEach(section => {
            observer.observe(section);
        });
    });

</script>
</body>
</html>
