import { RcoFrontendPage } from './app.po';

describe('rco-frontend App', () => {
  let page: RcoFrontendPage;

  beforeEach(() => {
    page = new RcoFrontendPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
