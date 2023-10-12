import { Router } from "express";
import { getArea, getChart, getList } from "../controllers/Data.js";

const router = Router();

router.get("/get-area", getArea);
router.get("/data-chart", getChart);
router.get("/data-list", getList);

export default router;
