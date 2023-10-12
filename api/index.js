import express from "express";
import cors from "cors";
import dotenv from "dotenv";
import router from "./routes/index.js";
import jwt from "./middleware/jsonWebToken.js";
import bodyParser from 'body-parser';

dotenv.config();

const app = express();

app.use(
  cors({
    credentials: true,
    origin: "*",
  })
);

app.use(express.json());

app.use(
  bodyParser.urlencoded({
    extended: true
  })
);

app.use("/api", router);

app.listen(process.env.APP_PORT, () => {
  console.log("Server up and running on port " + process.env.APP_PORT);
});
