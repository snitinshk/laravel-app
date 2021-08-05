<table>
    <thead>
    <tr>
        <th>Domain</th>
        <th>Company</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Email Status</th>
        <th>Position</th>
        <th>Source</th>
    </tr>
    </thead>
    <tbody>
    @foreach($domains as $CompanyEmail)
        <tr>
            <td>{{ $CompanyEmail->domain }}</td>
            <td>{{ $CompanyEmail->name }}</td>
            <td>{{ $CompanyEmail->first_name }}</td>
            <td>{{ $CompanyEmail->last_name }}</td>
            <td>{{ $CompanyEmail->email }}</td>
            <td>{{ ucwords($CompanyEmail->status) }}</td>
            <td>{{ $CompanyEmail->position }}</td>
            <td>{{ $CompanyEmail->source }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
