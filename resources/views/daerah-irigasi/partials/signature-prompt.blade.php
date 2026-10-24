<div class="signature-print-control no-print">
    <button id="open-signature-dialog" type="button">Cetak / Simpan PDF</button>
</div>

<dialog id="signature-dialog" class="signature-dialog no-print" aria-labelledby="signature-dialog-title">
    <form id="signature-form">
        <h2 id="signature-dialog-title">Data Penanda Tangan</h2>
        <div class="signature-fields">
            <div>
                <label for="signature-name">Nama Penanda Tangan</label>
                <input id="signature-name" type="text" maxlength="150" autocomplete="name">
            </div>
            <div>
                <label for="signature-nip">NIP (18 digit)</label>
                <input id="signature-nip" type="text" inputmode="numeric" pattern="[0-9]{18}" maxlength="18">
            </div>
        </div>
        <div class="signature-dialog-actions">
            <button id="print-report" type="button">Cetak / Simpan PDF</button>
            <button id="close-signature-dialog" type="button">Batal</button>
        </div>
    </form>
</dialog>

<script>
    const signatureDialog = document.getElementById('signature-dialog');
    const signatureForm = document.getElementById('signature-form');
    const nameInput = document.getElementById('signature-name');
    const nipInput = document.getElementById('signature-nip');

    document.getElementById('open-signature-dialog').addEventListener('click', function () {
        signatureDialog.showModal();
    });

    document.getElementById('close-signature-dialog').addEventListener('click', function () {
        signatureDialog.close();
    });

    document.getElementById('print-report').addEventListener('click', function () {
        nipInput.setCustomValidity(
            nipInput.value === '' || /^[0-9]{18}$/.test(nipInput.value)
                ? ''
                : 'NIP harus terdiri dari 18 digit angka.'
        );

        if (!signatureForm.reportValidity()) {
            return;
        }

        const nameOutput = document.getElementById('signature-name-output');
        const nipOutput = document.getElementById('signature-nip-output');
        const trimmedName = nameInput.value.trim();

        nameOutput.textContent = trimmedName ? '(' + trimmedName + ')' : '';
        nipOutput.textContent = nipInput.value ? 'NIP. ' + nipInput.value : '';
        signatureDialog.close();
        window.print();
    });
</script>
