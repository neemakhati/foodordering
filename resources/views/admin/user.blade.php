
<!DOCTYPE html>
<html lang="en">
<head>

    @include('admin.admincss')
    <style>
        table {
            width: 500px;
            border-collapse: collapse;
            margin-left: 100px;
            margin-bottom: 20px;
        }
        th, td {
            padding: 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #d5bcbc;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #453636;
        }
        tr:hover{
            background-color: #9c7b7b;
        }
        .action-links a {
            color: #e4e9ed;
            text-decoration: none;
            margin-right: 10px;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
        .user-table-container {
            margin: 100px;
            max-width: 600px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination li a, .pagination li span {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            background-color: #d5bcbc;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .pagination li a:hover {
            background-color: #9c7b7b;
        }
        .pagination li.disabled span {
            color: #999;
            background-color: #f5f5f5;
            border-color: #ddd;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    @include('admin.navbar')
    @include('notifyorder')
    <div class="user-table-container">
        <table>
            <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
{{--                <th>Change</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $index => $user)
                <tr>
                    <td>{{ $index + 1 + ($data->currentPage() - 1) * $data->perPage() }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="action-links">
                        <a href="{{ url('/deleteuser', $user->id) }}">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pagination-wrapper">
            @if ($data->hasPages())
                <nav>
                    <ul class="pagination">

                        @if ($data->onFirstPage())
                            <li class="disabled" aria-disabled="true">
                                <span>Previous</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $data->previousPageUrl() }}" rel="prev">Previous</a>
                            </li>
                        @endif

                        @if ($data->hasMorePages())
                            <li>
                                <a href="{{ $data->nextPageUrl() }}" rel="next">Next</a>
                            </li>
                        @else
                            <li class="disabled" aria-disabled="true">
                                <span>Next</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif
        </div>
    </div>
</div>
@include('admin.adminscript')
</body>
</html>
