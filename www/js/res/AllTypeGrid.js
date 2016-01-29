define([
               'dojo/_base/declare',
                'dstore/Rest',
                'dstore/Trackable',
                'dgrid/OnDemandGrid',
                'dgrid/Editor'
        ], function (declare, Rest, Trackable, OnDemandGrid, Editor) {
            
                var store = new Rest({
                target: '/AllType/'
            });

                // Instantiate grid
                var grid = new (declare([OnDemandGrid, Editor]))({
                        collection: store,
                            selectionMode: "single",
                        columns: {
                                text: {
                                        label: 'Строка',
                                    editor: 'text',
                                    editOn: 'click',
                                    autoSave: true
                                },
                                date: {
                                        label: 'Дата'
                                }
                        }
                }, 'AllType');

                return AllTypeGrid;
        });
