document.addEventListener('DOMContentLoaded', () => {
    const mapContainerElement = document.getElementById('amap-vmap-container');
    if (!mapContainerElement) return;

    const markersData = JSON.parse(mapContainerElement.getAttribute('data-markers') || '[]');
    const mapColor = mapContainerElement.getAttribute('data-map-color') || '#e9ecef';

    const vectorMapInstance = new jsVectorMap({
        selector: '#amap-vmap-container',
        map: 'world',
        markers: markersData,
        zoomButtons: false,
        zoomOnScroll: false,
        regionStyle: {
            initial: {
                fill: mapColor,
                fillOpacity: 1,
                stroke: 'none',
                strokeWidth: 0,
                strokeOpacity: 1
            },
            hover: {
                fillOpacity: 0.8,
                cursor: 'pointer'
            }
        },
        markerStyle: {
            initial: { fill: '#D32F2F', stroke: '#fff', strokeWidth: 1, r: 4 },
            hover: { fill: '#fff', stroke: '#D32F2F', strokeWidth: 2 }
        },
        onLoaded: () => {
            setTimeout(() => renderConnectorLines(markersData), 200);
        }
    });

    function renderConnectorLines(data) {
        const pluginWrapper = document.querySelector('.amap-wrapper');
        const svgLayer = pluginWrapper.querySelector('.amap-global-svg');
        
        if (!pluginWrapper || !svgLayer) return;

        svgLayer.innerHTML = '';
        const wrapperRect = pluginWrapper.getBoundingClientRect();

        document.querySelectorAll('.jvm-marker').forEach((markerNode) => {
            const dataIndex = markerNode.getAttribute('data-index');
            if (!data[dataIndex]) return;
            
            const allyEntityId = data[dataIndex].id;
            const gridItemElement = pluginWrapper.querySelector(`.amap-grid-item[data-id="${allyEntityId}"]`);
            
            if (!gridItemElement) return;

            const logoBoxElement = gridItemElement.querySelector('.amap-logo-box');
            if (!logoBoxElement) return;

            const markerRect = markerNode.getBoundingClientRect();
            const logoRect = logoBoxElement.getBoundingClientRect();

            const startCoordX = logoRect.left - wrapperRect.left + (logoRect.width / 2);
            const startCoordY = logoRect.top - wrapperRect.top + (logoRect.height / 2);
            const endCoordX = markerRect.left - wrapperRect.left + (markerRect.width / 2);
            const endCoordY = markerRect.top - wrapperRect.top + (markerRect.height / 2);

            const connectorLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
            connectorLine.setAttribute('x1', startCoordX);
            connectorLine.setAttribute('y1', startCoordY);
            connectorLine.setAttribute('x2', endCoordX);
            connectorLine.setAttribute('y2', endCoordY);
            connectorLine.setAttribute('class', 'amap-connector');
            connectorLine.setAttribute('data-id', allyEntityId);

            svgLayer.appendChild(connectorLine);
        });
    }

    window.addEventListener('resize', () => {
        requestAnimationFrame(() => renderConnectorLines(markersData));
    });

    document.querySelectorAll('.amap-grid-item').forEach(gridItem => {
        gridItem.addEventListener('mouseenter', function() {
            const entityId = this.getAttribute('data-id');
            const correspondingLine = document.querySelector(`.amap-connector[data-id="${entityId}"]`);
            if (correspondingLine) correspondingLine.classList.add('active');
        });
        
        gridItem.addEventListener('mouseleave', function() {
            const entityId = this.getAttribute('data-id');
            const correspondingLine = document.querySelector(`.amap-connector[data-id="${entityId}"]`);
            if (correspondingLine) correspondingLine.classList.remove('active');
        });
    });
});