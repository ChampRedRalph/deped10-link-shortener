import { Router } from 'express';
import LinkController from '../controllers/linkController';

const router = Router();
const linkController = new LinkController();

export function setLinkRoutes(app) {
    app.use('/api/links', router);
    
    router.post('/', linkController.createLink.bind(linkController));
    router.get('/:shortUrl', linkController.getLink.bind(linkController));
    router.delete('/:shortUrl', linkController.deleteLink.bind(linkController));
}