@extends('layouts.layout')

@section('style')

    <script src="https://unpkg.com/cytoscape@3.30.4/dist/cytoscape.min.js"></script>
@endsection

@section('content')
    <div id="cy" style="width: auto;height: 90vh"></div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '{{ route('api.techtree.buildings') }}',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    const elements = data.map(building => ({
                        data: {id: building.id, name: building.name, level: building.level}
                    }));

                    data.forEach(building => {
                        if (building.requirements && building.requirements.gebäude) {
                            building.requirements.gebäude.forEach(req => {
                                elements.push({
                                    data: {source: req.id, target: building.id}
                                });
                            });
                        }
                    });

                    function getRandomColor() {
                        const letters = '0123456789ABCDEF';
                        let color = '#';
                        for (let i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }

                    const cy = cytoscape({
                        container: document.getElementById('cy'),
                        elements: elements,
                        style: [
                            {
                                selector: 'node',
                                style: {
                                    'background-color': ele => {
                                        const level = ele.data('level');
                                        return ['#e0f7fa', '#b2ebf2', '#80deea', '#4dd0e1', '#26c6da'][level - 1] || '#ccc';
                                    },
                                    'label': 'data(name)',
                                    'width': 'label',
                                    'height': 'label',
                                    'padding': 10,
                                    'shape': 'rectangle',
                                    'color': '#FFF',
                                }
                            },
                            {
                                selector: 'edge',
                                style: {
                                    'width': 3,
                                    'line-color': getRandomColor,
                                    'target-arrow-shape': 'triangle',
                                    'target-arrow-color': getRandomColor,
                                    'curve-style': 'bezier'
                                }
                            }
                        ],
                        layout: {
                            name: 'breadthfirst',
                            directed: true,
                            padding: 10
                        }
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Fehler beim Abrufen der Gebäudedaten:', textStatus, errorThrown);
                }
            });
        });
    </script>
@endsection
