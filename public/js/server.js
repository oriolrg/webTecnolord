const express = require('express');
const tf = require('@tensorflow/tfjs-node');

const app = express();
app.use(express.json());

let model;

// Carregar el model guardat
async function carregarModel() {
    model = await tf.loadLayersModel('file://./model/model.json');
    console.log("✅ Model carregat!");
}
carregarModel();

// Endpoint per fer prediccions
app.post('/predir', async (req, res) => {
    if (!model) {
        return res.status(500).json({ error: "Model no carregat!" });
    }

    const { temperatura, humitat, pressio, vent } = req.body;
    const entrada = tf.tensor2d([[temperatura, humitat, pressio, vent]]);
    const resultat = model.predict(entrada);
    const probabilitat = (await resultat.data())[0];

    res.json({ probabilitat_pluja: Math.round(probabilitat * 100) });
});

const PORT = 5000;
app.listen(PORT, () => console.log(`✅ Servidor API executant-se a http://localhost:${PORT}`));
