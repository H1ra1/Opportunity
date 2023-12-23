<div class="oaa-bids-historic">
    <table>
        <thead>
            <tr>
                <th>Valor do Lance</th>
                <th>Licitante</th>
                <th>Cidade</th>
                <th>UF</th>
                <th>Data</th>
                <th>Horário</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach( $args[ 'bids' ] as $bid ): ?>
                <tr>
                    <td><?php esc_html_e( "R$ {$bid->bid}" ); ?></td>
                    <td><?php esc_html_e( ucwords( $bid->name ) ); ?></td>
                    <td>~</td>
                    <td>~</td>
                    <td><?php esc_html_e( $bid->date ); ?></td>
                    <td><?php esc_html_e( $bid->time ); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>