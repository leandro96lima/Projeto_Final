
    <div class="insidecontainer">
        <form id="equipment-form" action="{{ route('equipments.store')}}">
            @csrf
            <input type="hidden" name="from_partial" value="user-create-equipment">

            <br>
            <div class="ICtitulo">
                <label for="nomeavaria">{{__('Detalhes da Avaria:')}}</label>
            </div>
            <br>
            <div class="card1">
                <h4>{{__('Tipo de Equipamento:')}}</h4>
                <br>
                <input type="text" id="type" name="type" value="{{ old('type', $other_type ?? '') }}" readonly>
                @error('type')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="card1">
                <h4>{{__('Novo Tipo de Equipamento:')}}</h4>
                <input type="text" id="new_type" name="new_type" value="{{ old('new_type', '') }}">
                <br>

            </div>
            <div class="card1">
                <h4>{{__('Fabricante:')}}</h4>
                <br>
                <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer', '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                @error('manufacturer')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror </div>


            <div class="card1">
                <h4>{{__('Modelo:')}}</h4>
                <br>
                <input type="text" name="Modelo" id="Modelo" placeholder="Modelo do Equipamento" required>
            </div>


            <div class="card1">
                <h4>{{__('Serial Number:')}}</h4>
                <br>
                <input type="text" id="serialnumber" name="serialnumber" placeholder="Serial Number" required>
            </div>

            <div class="card1">
                <h4>{{__('Sala:')}}</h4>
                <br>
                <input type="text" id="sala" name="sala" placeholder="Sala" required>
            </div>

            <div class="botoes">
                <br>
                <a href="">
                    <input type="submit" id="botao_p" value="Gravar">
                </a>
                <a href="ticket.html">
                    <input type="button" id="botao2" value="Cancelar">
                </a>
            </div>
        </form>
    </div>











<style>






    }


    #detalhes {
        font-size: 16px; /* Adjusts the font size of the input text */

        width:100% ;
        height: 300px; /* Sets a specific height for the input */
        line-height: 1.2; /* Adjusts line height for better alignment */
        box-sizing: border-box; /* Ensures padding is included in total width/height */
        padding: 10px; /* Add some padding */
        vertical-align: top; /* Align text to the top */
        text-align: left; /* Ensure text is left-aligned */
        resize: none; /* Prevent resizing if it's a textarea */
    }

    #detalhes::placeholder {
        font-size: 16px; /* Adjusts the font size of the placeholder text */


    }




    #serialnumber{
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 30%;
        border-radius: 30px;



    }


    #nomeequipamento{
        font-size: 16px; /* Adjusts the font size of the input text */
        line-height: 1.2; /* Adjusts line height for better alignment */
        width: 20%;





    }


    #Tipoequipamento{
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 30%;
        border-radius: 30px;


    }


    #Modelo{
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 30%;
        border-radius: 30px;



    }


    #Fabricante{
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 30%;
        border-radius: 30px;



    }

    #sala{
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 30%;
        border-radius: 30px;

    }

    .botoes{
        display: flex;
        flex-direction: row;
        margin: 10px;
    }


    #botao2 {
        width: 150px;
        height: 65px;
        margin: 10px;
        border-radius: 20px;
        border: 1px solid #dc3545;
        background-color: #dc3545;
        color: #FFFFFF;
        font-size: 15px;
        font-weight: bold;
        padding: 12px ;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
        text-align: center;
    }


    #botao2:hover{
        background-color: #dc3545; /* Darken the background on hover */

        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Enhance shadow on hover */


    }


    #botao2:active {
        transform: scale(0.95);
    }

    a {
        outline: none; /* Remove o contorno padrão */
        text-decoration: none; /* Remove o sublinhado, se desejado */
        color: white;
    }





</style>
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
