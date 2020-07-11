import ApiService from './api.service'

class PropertyService extends ApiService {
  constructor () {
    super({ segment: 'properties' })
  }

  list() {
    return this.client.get();
  }

}

export default new PropertyService()
