<section style="margin-bottom: 24px;">
    <header>
        <h2 style="font-size: 1.25rem; font-weight: 500; color: #1f2937;">
            Deletar conta
        </h2>

        <p style="margin-top: 4px; font-size: 0.875rem; color: #4b5563;">
            Uma vez que sua conta for deletada, todos os seus recursos e dados serão permanentemente excluídos. Antes de deletar sua conta, por favor, faça o download de quaisquer dados ou informações que você deseja manter.
        </p>

    </header>
<br>
    <button
        onclick="openModal('confirm-user-deletion')"
        style="    width: 350px;
    margin: 10px;
	border-radius: 20px;
	border: 1px solid #dc3545;
	background-color: #dc3545;
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
	padding: 12px 45px;
	letter-spacing: 1px;
	text-transform: uppercase;
	transition: transform 80ms ease-in;
    text-align: center;"
    >
        Deletar Conta
    </button>

    <div id="confirm-user-deletion" style="display: none; background: rgba(0, 0, 0, 0.5); position: fixed; top: 0; left: 0; right: 0; bottom: 0; justify-content: center; align-items: center;">
        <div style="background: white; padding: 24px; border-radius: 8px; width: 400px;">
            <h2 style="font-size: 1.25rem; font-weight: 500; color: #1f2937;">
                Você tem certeza de que deseja deletar sua conta?
            </h2>

            <p style="margin-top: 4px; font-size: 0.875rem; color: #4b5563;">
                Uma vez que sua conta for deletada, todos os seus recursos e dados serão permanentemente excluídos. Por favor, insira sua senha para confirmar que você deseja deletar sua conta permanentemente.
            </p>

            <div style="margin-top: 24px;">
                <label for="password" style="display: none;">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    style="margin-top: 4px; width: 75%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;"
                    placeholder="Senha"
                />
                <div style="color: red; margin-top: 8px;" id="password-error"></div>
            </div>

            <div style="margin-top: 24px; display: flex; justify-content: flex-end;">
                <button
                    onclick="closeModal()"
                    style="background-color: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    style="background-color: #e3342f; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-left: 12px;"
                >
                    Deletar Conta
                </button>
            </div>
        </div>
    </div>
</section>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('confirm-user-deletion').style.display = 'none';
    }
</script>
