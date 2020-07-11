import ApiService from './api.service'

class CityService extends ApiService {
  constructor () {
    super({ segment: 'states' })
  }

  listStates() {
    return this.client.get(``);
  }

  listCities({state}) {
    return this.client.get(`${state}/cities`);
  }
 
}

export default new CityService()
