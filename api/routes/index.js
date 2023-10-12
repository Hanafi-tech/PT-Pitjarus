import { Router } from "express";
import DataRoute from "./DataRoute.js";

const router = Router();

router.use("/", DataRoute);

export default router;
