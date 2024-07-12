<h2>Verificación de Campos</h2>

<p>Total de registros revisados: <?php echo $totalRegistros; ?></p>

<?php if (!empty($registrosInvalidos)): ?>
    <p>Existen campos nulos en los siguientes registros:</p>
    <table>
        <thead>
            <tr>
                <th>ID del Registro</th>
                <th>Campos Nulos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrosInvalidos as $invalido): ?>
                <tr>
                    <td><?php echo $invalido['registro']['Pago']['id']; ?></td>
                    <td><?php echo implode(', ', $invalido['camposNulos']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Todos los campos están completos en los últimos 1000 registros.</p>
<?php endif; ?>
