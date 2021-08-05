<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Website</th>
        <th>Industry</th>
        <th>Head Office Location</th>
        <th>Type</th>
        <th>Founded</th>
        <th>Specialities</th>
        <th>Overview</th>
        <th>Head Count</th>
        <th>Sales Nav URL</th>
    </tr>
    </thead>
    <tbody>
    @foreach($companies as $Company)
        <tr>
            <td>{{ $Company->name }}</td>
            <td>{{ $Company->website }}</td>
            <td>{{ $Company->industry_desc }}</td>
            <td>{{ $Company->headquarters_location }}</td>
            <td>{{ $Company->incorporation_type }}</td>
            <td>{{ $Company->founded_year }}</td>
            <td>{{ $Company->specialities }}</td>
            <td>{{ $Company->overview }}</td>
            <td>{{ $Company->headcount }}</td>
            <td>{{ $Company->sales_link }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
