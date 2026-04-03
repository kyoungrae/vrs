<!DOCTYPE html>
<html>
<head>
    <title>Debug Archives</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .section { margin-bottom: 30px; }
    </style>
</head>
<body>
    <h1>Debug Archives</h1>
    
    <div class="section">
        <h2>Current Auth Session</h2>
        @if($auth)
            <table>
                <tr><th>Field</th><th>Value</th></tr>
                <tr><td>ID</td><td>{{ $auth->id ?? 'N/A' }}</td></tr>
                <tr><td>Username</td><td>{{ $auth->username ?? 'N/A' }}</td></tr>
                <tr><td>ProvinceId</td><td>{{ $auth->provinceid ?? 'N/A' }}</td></tr>
                <tr><td>IsAtvt</td><td>{{ $auth->isatvt ?? 'N/A' }}</td></tr>
                <tr><td>IsCity</td><td>{{ $auth->iscity ?? 'N/A' }}</td></tr>
            </table>
        @else
            <p>No auth session found</p>
        @endif
    </div>
    
    <div class="section">
        <h2>SYSTEM_ARCHIVE Records (ProvinceId=22)</h2>
        @if($archives && count($archives) > 0)
            <table>
                <tr>
                    <th>ID</th>
                    <th>PROVINCEID</th>
                    <th>ARCHIVE</th>
                    <th>IS_TYPE</th>
                    <th>DELETED_AT</th>
                </tr>
                @foreach($archives as $archive)
                    <tr>
                        <td>{{ $archive->ID }}</td>
                        <td>{{ $archive->PROVINCEID }}</td>
                        <td>{{ $archive->ARCHIVE }}</td>
                        <td>{{ $archive->IS_TYPE }}</td>
                        <td>{{ $archive->DELETED_AT ?? 'NULL' }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>No archives found for ProvinceId=22 with DELETED_AT IS NULL</p>
        @endif
    </div>
    
    <div class="section">
        <h2>Branch Selection Logic Simulation</h2>
        @if($auth && $archives && count($archives) > 0)
            <table>
                <tr>
                    <th>Archive</th>
                    <th>IS_TYPE</th>
                    <th>Condition Check</th>
                    <th>Will Show?</th>
                </tr>
                @foreach($archives as $archive)
                    <tr>
                        <td>{{ $archive->ARCHIVE }}</td>
                        <td>{{ $archive->IS_TYPE }}</td>
                        <td>
                            @if($archive->IS_TYPE == 1 && $auth->isatvt == 1 && $auth->iscity == 0)
                                ATVT Admin (is_type=1, isatvt=1, iscity=0)
                            @elseif($archive->IS_TYPE == 2 && $auth->iscity == 1 && $auth->isatvt == 0)
                                City Admin (is_type=2, iscity=1, isatvt=0)
                            @elseif($archive->IS_TYPE == 1 && $auth->isatvt == 0 && $auth->iscity == 0)
                                Other (is_type=1, isatvt=0, iscity=0)
                            @else
                                No match
                            @endif
                        </td>
                        <td>
                            @if($archive->IS_TYPE == 1 && $auth->isatvt == 1 && $auth->iscity == 0)
                                ✅ YES
                            @elseif($archive->IS_TYPE == 2 && $auth->iscity == 1 && $auth->isatvt == 0)
                                ✅ YES
                            @elseif($archive->IS_TYPE == 1 && $auth->isatvt == 0 && $auth->iscity == 0)
                                ✅ YES
                            @else
                                ❌ NO
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>Cannot simulate - missing auth or archives</p>
        @endif
    </div>
    
    <div class="section">
        <a href="{{ url('/dev/create-test-user') }}">Create/Update TEST User</a> | 
        <a href="{{ url('/') }}">Back to Home</a>
    </div>
</body>
</html>
