const tf = require('@tensorflow/tfjs-node');
const fs = require('fs');

// Simulem dades (idealment, les hauries d'obtenir de MySQL)
async function carregarDades() {
    return {
        X: [[18, 85, 1005, 10], [25, 50, 1012, 5], [20, 75, 1010, 8]], // Temperatura, humitat, pressió, vent
        y: [[1], [0], [1]] // 1 = Pluja, 0 = No pluja
    };
}

async function entrenarIGuardarModel() {
    const { X, y } = await carregarDades();

    const tensorX = tf.tensor2d(X);
    const tensorY = tf.tensor2d(y);

    const model = tf.sequential();
    model.add(tf.layers.dense({ inputShape: [4], units: 8, activation: 'relu' }));
    model.add(tf.layers.dense({ units: 4, activation: 'relu' }));
    model.add(tf.layers.dense({ units: 1, activation: 'sigmoid' }));

    model.compile({
        optimizer: 'adam',
        loss: 'binaryCrossentropy',
        metrics: ['accuracy']
    });

    await model.fit(tensorX, tensorY, {
        epochs: 50,
        batchSize: 32,
        shuffle: true
    });

    console.log("✅ Model entrenat!");

    // Guardar el model al servidor
    await model.save(`file://./model`);
    console.log("✅ Model guardat correctament!");
}

entrenarIGuardarModel();
