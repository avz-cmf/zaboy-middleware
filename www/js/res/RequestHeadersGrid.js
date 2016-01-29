define([
                'dojo/_base/declare',
                'dstore/Rest',
                'dstore/Trackable',
                'dgrid/OnDemandGrid',
                'dgrid/Editor'
        ], function (declare, Rest, Trackable, OnDemandGrid, Editor) {
            
                var store = new Rest({
                target: '/GetAllRequestHeaders/'
            });

                // Instantiate grid
                var RequestHeadersGrid = new (declare([OnDemandGrid, Editor]))({
                        collection: store,
                            selectionMode: "single",
                        columns: {
                                Header_Name: {
                                        label: 'Header Name',
                                    editor: 'text',
                                    editOn: 'click',
                                    autoSave: true
                                },
                                Header_Value: {
                                        label: 'Header Value'
                                }
                        }
                }, 'MainRequestHeadesrsGrid');

                return RequestHeadersGrid;
        });