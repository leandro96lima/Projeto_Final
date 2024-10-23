<h1>Solicitações de Alteração de Tipo</h1>

<table>
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Tipo Solicitado</th>
        <th>Motivo</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    @foreach($requests as $request)
        <tr>
            <td>{{ $request->user->name }}</td>
            <td>{{ $request->requested_type }}</td>
            <td>{{ $request->reason }}</td>
            <td>{{ $request->status }}</td>
            <td>
                <form method="POST" action="{{ route('admin.approve-type-change-request', $request) }}">
                    @csrf
                    <button type="submit">Aprovar</button>
                </form>
                <form method="POST" action="{{ route('admin.reject-type-change-request', $request) }}">
                    @csrf
                    <button type="submit">Rejeitar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
