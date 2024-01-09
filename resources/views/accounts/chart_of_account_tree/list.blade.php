@extends('layouts.form')
@section('title', $data['title'])
@section('themeStyle')

    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/jstree.min.css')}}">

@endsection

@section('style')

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/extensions/ext-component-tree.css')}}">
@endsection

@section('content')
    @permission($data['permission'])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="card-left-side">
                        <h4 class="card-title">{{$data['title']}}</h4>
                    </div>
                    <div class="card-link">

                    </div>
                </div>
                <div class="card-body mt-2">

                    <div id="jstree-ajax"></div>
                </div>
            </div>
        </div>
    </div>
    @endpermission
@endsection

@section('pageJs')

    <script src="{{ asset('/assets/vendors/js/extensions/jstree.min.js') }}"></script>

@endsection

@section('script')
    {{--<script src="{{ asset('/assets/js/scripts/extensions/ext-component-tree.js') }}"></script>--}}
    <script>

        $(function () {
            'use strict';

            var ajaxTree = $('#jstree-ajax');


            var tree_url = '{{route('accounts.chart-of-account-tree.getChartOfAccountTree')}}';

            // Ajax Example
            if (ajaxTree.length) {
                ajaxTree.jstree({
                    core: {
                        data: {
                            url: tree_url,
                            dataType: 'json',
                            data: function (node) {
                                return {
                                    id: node.id
                                };
                            }
                        }
                    },
                    plugins: ['types', 'state'],
                    types: {
                        default: {
                            icon: 'far fa-folder'
                        },
                        html: {
                            icon: 'fab fa-html5 text-danger'
                        },
                        css: {
                            icon: 'fab fa-css3-alt text-info'
                        },
                        img: {
                            icon: 'far fa-file-image text-success'
                        },
                        js: {
                            icon: 'fab fa-node-js text-warning'
                        }
                    }
                });
            }

        });
    </script>
@endsection
